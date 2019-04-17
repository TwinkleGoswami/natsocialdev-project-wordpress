/**
 * theme-script.js
 *
 */

!(function($) {
    "use strict";

    String.prototype.replaceMap = function(mapObj) {
        var string = this,
            key;

        for (key in mapObj)
            string = string.replace(new RegExp('\\{' + key + '\\}', 'gm'), mapObj[key]);

        return string;
    };

    /**
     * Custom select ui
     *
     */
    $.fn.customSelectUi = function(opts) {
        return $(this).each(function(opts) {
            var self = this,
                _opts = $.extend({
                    'className': 'custom-select-ui'
                }, opts);

            $(self).wrap("<div class='{className}'></div>".replaceMap({ className: _opts.className }));
        })
    }

    /**
     * only called once
     *
     */
    $.fn._once = function(handle) {
        return $(this).each(function() {
            var $this = $(this);
            if ($this.data('bears-once-handle') == true) return;

            $this.data('bears-once-handle', true);
            handle.call(this);
        })
    }

    $.fn.stripClass = function(partialMatch, endOrBegin) {
        var x = new RegExp((!endOrBegin ? "\\b" : "\\S+") + partialMatch + "\\S*", 'g');
        this.attr('class', function(i, c) {
            if (!c) return;
            return c.replace(x, '');
        });
        return this;
    };

    function _check_MSIEversion() {
      var ua = window.navigator.userAgent;
      var msie = ua.indexOf("MSIE ");

      if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        return true;
      }
      else  {
        return false;
      }

    }

    /**
     * Liquid Button script
     *
     */
    var _createClass = function() {
        function defineProperties(target, props) {
            for (var i = 0; i < props.length; i++) {
                var descriptor = props[i];
                descriptor.enumerable = descriptor.enumerable || false;
                descriptor.configurable = true;
                if ("value" in descriptor) descriptor.writable = true;
                Object.defineProperty(target, descriptor.key, descriptor);
            }
        }
        return function(Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; };
    }();

    function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

    var LiquidButton = function(svg) {

        /* break to IE */
        // alert(_check_MSIEversion());
        if(_check_MSIEversion()) return;

        _classCallCheck(this, LiquidButton);

        var _opts = $.extend({
          tension: 0.4,
          width: 200,
          height: 50,
          margin: 50,
          hoverFactor: -0.1,
          gap: 5,
          debug: false,
          forceFactor: 0.2,
          color1: '#36DFE7',
          color2: '#8F17E1',
          color3: '#BF09E6',
          textColor: '#FFFFFF',
          text: '',
        }, svg.dataset);

        var options = _opts; //svg.dataset;

        this.id = this.constructor.id || (this.constructor.id = 1);
        this.constructor.id++;
        this.xmlns = 'http://www.w3.org/2000/svg';
        this.tension = options.tension * 1 || 0.4;
        this.width = options.width * 1 || 200;
        this.height = options.height * 1 || 50;
        this.margin = options.margin || 50;
        this.hoverFactor = options.hoverFactor || -0.1;
        this.gap = options.gap || 5;
        this.debug = options.debug || false;
        this.forceFactor = options.forceFactor || 0.2;
        this.color1 = options.color1 || '#36DFE7';
        this.color2 = options.color2 || '#8F17E1';
        this.color3 = options.color3 || '#BF09E6';
        this.textColor = options.textColor || '#FFFFFF';
        this.text = options.text || ''; //'▶';
        this.svg = svg;
        this.layers = [{
            points: [],
            viscosity: 0.5,
            mouseForce: 100,
            forceLimit: 2
        }, {
            points: [],
            viscosity: 0.8,
            mouseForce: 150,
            forceLimit: 3
        }];
        for (var layerIndex = 0; layerIndex < this.layers.length; layerIndex++) {
            var layer = this.layers[layerIndex];
            layer.viscosity = options['layer-' + (layerIndex + 1) + 'Viscosity'] * 1 || layer.viscosity;
            layer.mouseForce = options['layer-' + (layerIndex + 1) + 'MouseForce'] * 1 || layer.mouseForce;
            layer.forceLimit = options['layer-' + (layerIndex + 1) + 'ForceLimit'] * 1 || layer.forceLimit;
            layer.path = document.createElementNS(this.xmlns, 'path');
            this.svg.appendChild(layer.path);
        }
        this.wrapperElement = options.wrapperElement || document.body;
        if (!this.svg.parentElement) {
            // this.wrapperElement.append(this.svg);
            this.wrapperElement.appendChild(this.svg);
        }

        this.svgText = document.createElementNS(this.xmlns, 'text');
        this.svgText.setAttribute('x', '50%');
        this.svgText.setAttribute('y', '50%');
        this.svgText.setAttribute('dy', ~~(this.height / 8) + 'px');
        this.svgText.setAttribute('font-size', ~~(this.height / 3));
        this.svgText.style.fontFamily = 'sans-serif';
        this.svgText.setAttribute('text-anchor', 'middle');
        this.svgText.setAttribute('pointer-events', 'none');
        this.svg.appendChild(this.svgText);

        this.svgDefs = document.createElementNS(this.xmlns, 'defs');
        this.svg.appendChild(this.svgDefs);

        this.touches = [];
        this.noise = options.noise || 0;
        document.body.addEventListener('touchstart', this.touchHandler);
        document.body.addEventListener('touchmove', this.touchHandler);
        document.body.addEventListener('touchend', this.clearHandler);
        document.body.addEventListener('touchcancel', this.clearHandler);
        this.svg.addEventListener('mousemove', this.mouseHandler);
        this.svg.addEventListener('mouseout', this.clearHandler);
        this.initOrigins();
        this.animate();
    }

    LiquidButton.prototype.distance = function distance(p1, p2) {
        return Math.sqrt(Math.pow(p1.x - p2.x, 2) + Math.pow(p1.y - p2.y, 2));
    };

    LiquidButton.prototype.update = function update() {
        for (var layerIndex = 0; layerIndex < this.layers.length; layerIndex++) {
            var layer = this.layers[layerIndex];
            var points = layer.points;
            for (var pointIndex = 0; pointIndex < points.length; pointIndex++) {
                var point = points[pointIndex];
                var dx = point.ox - point.x + (Math.random() - 0.5) * this.noise;
                var dy = point.oy - point.y + (Math.random() - 0.5) * this.noise;
                var d = Math.sqrt(dx * dx + dy * dy);
                var f = d * this.forceFactor;
                point.vx += f * (dx / d || 0);
                point.vy += f * (dy / d || 0);
                for (var touchIndex = 0; touchIndex < this.touches.length; touchIndex++) {
                    var touch = this.touches[touchIndex];
                    var mouseForce = layer.mouseForce;
                    if (touch.x > this.margin && touch.x < this.margin + this.width && touch.y > this.margin && touch.y < this.margin + this.height) {
                        mouseForce *= -this.hoverFactor;
                    }
                    var mx = point.x - touch.x;
                    var my = point.y - touch.y;
                    var md = Math.sqrt(mx * mx + my * my);
                    var mf = Math.max(-layer.forceLimit, Math.min(layer.forceLimit, mouseForce * touch.force / md));
                    point.vx += mf * (mx / md || 0);
                    point.vy += mf * (my / md || 0);
                }
                point.vx *= layer.viscosity;
                point.vy *= layer.viscosity;
                point.x += point.vx;
                point.y += point.vy;
            }
            for (var pointIndex = 0; pointIndex < points.length; pointIndex++) {
                var prev = points[(pointIndex + points.length - 1) % points.length];
                var point = points[pointIndex];
                var next = points[(pointIndex + points.length + 1) % points.length];
                var dPrev = this.distance(point, prev);
                var dNext = this.distance(point, next);

                var line = {
                    x: next.x - prev.x,
                    y: next.y - prev.y
                };
                var dLine = Math.sqrt(line.x * line.x + line.y * line.y);

                point.cPrev = {
                    x: point.x - line.x / dLine * dPrev * this.tension,
                    y: point.y - line.y / dLine * dPrev * this.tension
                };
                point.cNext = {
                    x: point.x + line.x / dLine * dNext * this.tension,
                    y: point.y + line.y / dLine * dNext * this.tension
                };
            }
        }
    };

    LiquidButton.prototype.animate = function animate() {
        var _this = this;

        this.raf(function() {
            _this.update();
            _this.draw();
            _this.animate();
        });
    };

    LiquidButton.prototype.draw = function draw() {
        for (var layerIndex = 0; layerIndex < this.layers.length; layerIndex++) {
            var layer = this.layers[layerIndex];
            if (layerIndex === 1) {
                if (this.touches.length > 0) {
                    while (this.svgDefs.firstChild) {
                        this.svgDefs.removeChild(this.svgDefs.firstChild);
                    }
                    for (var touchIndex = 0; touchIndex < this.touches.length; touchIndex++) {
                        var touch = this.touches[touchIndex];
                        var gradient = document.createElementNS(this.xmlns, 'radialGradient');
                        gradient.id = 'liquid-gradient-' + this.id + '-' + touchIndex;
                        var start = document.createElementNS(this.xmlns, 'stop');
                        start.setAttribute('stop-color', this.color3);
                        start.setAttribute('offset', '0%');
                        var stop = document.createElementNS(this.xmlns, 'stop');
                        stop.setAttribute('stop-color', this.color2);
                        stop.setAttribute('offset', '100%');
                        gradient.appendChild(start);
                        gradient.appendChild(stop);
                        this.svgDefs.appendChild(gradient);
                        gradient.setAttribute('cx', touch.x / this.svgWidth);
                        gradient.setAttribute('cy', touch.y / this.svgHeight);
                        gradient.setAttribute('r', touch.force);
                        layer.path.style.fill = 'url(#' + gradient.id + ')';
                    }
                } else {
                    layer.path.style.fill = this.color2;
                }
            } else {
                layer.path.style.fill = this.color1;
            }
            var points = layer.points;
            var commands = [];
            commands.push('M', points[0].x, points[0].y);
            for (var pointIndex = 1; pointIndex < points.length; pointIndex += 1) {
                commands.push('C', points[(pointIndex + 0) % points.length].cNext.x, points[(pointIndex + 0) % points.length].cNext.y, points[(pointIndex + 1) % points.length].cPrev.x, points[(pointIndex + 1) % points.length].cPrev.y, points[(pointIndex + 1) % points.length].x, points[(pointIndex + 1) % points.length].y);
            }
            commands.push('Z');
            layer.path.setAttribute('d', commands.join(' '));
        }
        this.svgText.textContent = this.text;
        this.svgText.style.fill = this.textColor;
    };

    LiquidButton.prototype.createPoint = function createPoint(x, y) {
        return {
            x: x,
            y: y,
            ox: x,
            oy: y,
            vx: 0,
            vy: 0
        };
    };

    LiquidButton.prototype.initOrigins = function initOrigins() {
        this.svg.setAttribute('width', this.svgWidth);
        this.svg.setAttribute('height', this.svgHeight);
        for (var layerIndex = 0; layerIndex < this.layers.length; layerIndex++) {
            var layer = this.layers[layerIndex];
            var points = [];
            for (var x = ~~(this.height / 2); x < this.width - ~~(this.height / 2); x += this.gap) {
                points.push(this.createPoint(x + this.margin, this.margin));
            }
            for (var alpha = ~~(this.height * 1.25); alpha >= 0; alpha -= this.gap) {
                var angle = Math.PI / ~~(this.height * 1.25) * alpha;
                points.push(this.createPoint(Math.sin(angle) * this.height / 2 + this.margin + this.width - this.height / 2, Math.cos(angle) * this.height / 2 + this.margin + this.height / 2));
            }
            for (var x = this.width - ~~(this.height / 2) - 1; x >= ~~(this.height / 2); x -= this.gap) {
                points.push(this.createPoint(x + this.margin, this.margin + this.height));
            }
            for (var alpha = 0; alpha <= ~~(this.height * 1.25); alpha += this.gap) {
                var angle = Math.PI / ~~(this.height * 1.25) * alpha;
                points.push(this.createPoint(this.height - Math.sin(angle) * this.height / 2 + this.margin - this.height / 2, Math.cos(angle) * this.height / 2 + this.margin + this.height / 2));
            }
            layer.points = points;
        }
    };

    _createClass(LiquidButton, [{
        key: 'mouseHandler',
        get: function get() {
            var _this2 = this;

            return function(e) {
                _this2.touches = [{
                    x: e.offsetX,
                    y: e.offsetY,
                    force: 1
                }];
            };
        }
    }, {
        key: 'touchHandler',
        get: function get() {
            var _this3 = this;

            return function(e) {
                _this3.touches = [];
                var rect = _this3.svg.getBoundingClientRect();
                for (var touchIndex = 0; touchIndex < e.changedTouches.length; touchIndex++) {
                    var touch = e.changedTouches[touchIndex];
                    var x = touch.pageX - rect.left;
                    var y = touch.pageY - rect.top;
                    if (x > 0 && y > 0 && x < _this3.svgWidth && y < _this3.svgHeight) {
                        _this3.touches.push({ x: x, y: y, force: touch.force || 1 });
                    }
                }
                e.preventDefault();
            };
        }
    }, {
        key: 'clearHandler',
        get: function get() {
            var _this4 = this;

            return function(e) {
                _this4.touches = [];
            };
        }
    }, {
        key: 'raf',
        get: function get() {
            return this.__raf || (this.__raf = (window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || function(callback) {
                setTimeout(callback, 10);
            }).bind(window));
        }
    }, {
        key: 'svgWidth',
        get: function get() {
            return this.width + this.margin * 2;
        }
    }, {
        key: 'svgHeight',
        get: function get() {
            return this.height + this.margin * 2;
        }
    }]);

    /* End Liquid Button */

    /**
     * MasonryHybrid
     * http://plugin.bearsthemes.com/jquery/MasonryHybrid/jquery.masonry-hybrid.js
     * Create Date: 31-08-2016
     * Version: 1.0.2
     * Author: Bearsthemes
     * Change log:
     *  + Add options Resposive (v1.0.2)
     *	+ fix items space wrong when resize browser (v1.0.1)
     */

    var MasonryHybrid = function($elem, opts) {
        this.elem = $elem;
        this.opts = $.extend({
            itemSelector: '.grid-item',
            columnWidth: '.grid-sizer',
            gutter: '.gutter-sizer',
            col: 4,
            space: 20,
            percentPosition: false,
            responsive: {
                860: { col: 2 },
                577: { col: 1 },
            },
        }, opts);
        // console.log(this.opts);
        this.init();
        return this;
    }

    MasonryHybrid.prototype = {
        init: function() {
            var self = this;

            // call applySelectorClass()
            self.applySelectorClass();

            // call renderStyle()
            self.renderStyle();

            // call applyMasonry()
            self.applyMasonry();

            // apply triggerEvent
            self.triggerEvent();

            // apply window resize (fix)
            self.resizeHandle();

            // window on load complete
            $(window).on('load', function() {
                // f5 grid
                self.elem.trigger('grid:refresh');
            })
        },
        applySelectorClass: function() {
            this.elemClass = 'masonry_hybrid-' + Math.random().toString(36).replace(/[^a-z]+/g, '').substr(0, 9);
            this.elem.addClass(this.elemClass);
        },
        renderStyle: function() {
            var self = this,
                css = '';

            self.style = $('<style>'),
                css += ' .{elemClass} { margin-left: -{space}px; width: calc(100% + {space}px); transition-property: height, width; }';
            css += ' .{elemClass} {itemSelector}, .{elemClass} {columnWidth} { width: calc(100% / {col}); }';
            css += ' .{elemClass} {gutter} { width: 0; }';
            css += ' .{elemClass} {itemSelector} { float: left; box-sizing: border-box; padding-left: {space}px; padding-bottom: {space}px; }';

            // resize
            css += ' .{elemClass} {itemSelector}.ui-resizable-resizing { z-index: 999 }';
            css += ' .{elemClass} {itemSelector} .screen-size{ visibility: hidden; transition: .5s; -webkit-transition: .5s; opacity: 0; position: absolute; bottom: calc({space}px + 8px); right: 9px; padding: 2px 4px; border-radius: 2px; font-size: 11px; }';
            css += ' .{elemClass} {itemSelector}.ui-resizable-resizing .screen-size{ visibility: visible; opacity: 1; }';
            css += ' .{elemClass} {itemSelector} .ui-resizable-se { right: 0; bottom: {space}px; opacity: 0; }';
            css += ' .{elemClass} {itemSelector}:hover .ui-resizable-se { opacity: 1; }';

            // extra size
            for (var i = 1; i <= self.opts.col; i++) {
                var _width = (100 / self.opts.col) * i;
                css += '.{elemClass} .grid-item--width' + i + ' { width: ' + _width + '% }';
            }

            // responsive
            var responsive_css = "";
            if (self.opts.responsive != false) {
                $.each(self.opts.responsive, function($k, $v) {
                    responsive_css = ' @media (max-width: ' + $k + 'px){ .{elemClass} {itemSelector}, .{elemClass} {columnWidth} { width: calc(100% / ' + $v.col + '); } }' + responsive_css;
                })
                css += responsive_css;
            }

            // replace
            css = css.replaceMap({
                elemClass: self.elemClass,
                itemSelector: self.opts.itemSelector,
                gutter: self.opts.gutter,
                columnWidth: self.opts.columnWidth,
                space: self.opts.space,
                col: self.opts.col
            });

            self.elem.prepend(self.style.html(css));
        },
        clearStyle: function() {
            this.style.remove();
            return this;
        },
        applyMasonry: function() {
            var self = this;

            this.grid = self.elem.isotope({
                itemSelector: self.opts.itemSelector,
                percentPosition: self.opts.percentPosition,
                masonry: {
                    columnWidth: self.opts.columnWidth,
                    gutter: self.opts.gutter,
                }
            });
        },
        resizeHandle: function() {
            var self = this;
            this.is_window_resize = '';

            // fix window resize
            $(window).on('resize.MasonryHybrid', function() {
                /* check is resize */
                if (this.is_window_resize) { self.clearTimeout(self.is_window_resize) }

                /* refresh */
                self.is_window_resize = setTimeout(function() {
                    self.elem.trigger('grid:refresh');
                }, 100)
            })
        },
        triggerEvent: function() {
            var self = this;

            self.elem.on({
                'grid:refresh': function(e, opts_update) {
                    if (opts_update) {
                        self.opts = $.extend(self.opts, opts_update);
                        self.clearStyle().renderStyle();
                    }

                    // trigger layout
                    self.grid.isotope('layout').delay(500).queue(function() {
                        self.grid.isotope('layout');
                        $(this).dequeue();
                    });
                }
            })
        }
    }

    MasonryHybrid.prototype.resize = function(opts) {
            var self = this;
            self._resize = {};

            // set options
            self._resize.opts = $.extend({
                celHeight: 140,
                sizeMap: [
                    [1, 1]
                ],
                resize: false,
            }, opts);

            // func applySize
            self._resize.applySize = function() {
                var countItem = self.elem.find(self.opts.itemSelector).length,
                    countSizeMap = self._resize.opts.sizeMap.length;

                for (var i = 0, j = 0; i <= countItem; i++) {
                    var _width = self._resize.opts.sizeMap[j][0],
                        _height = self._resize.opts.celHeight * self._resize.opts.sizeMap[j][1];

                    self.elem.find(self.opts.itemSelector).eq(i)
                        .data('grid-size', [self._resize.opts.sizeMap[j][0], self._resize.opts.sizeMap[j][1]])
                        .stripClass('grid-item--width')
                        .addClass('grid-item--width' + _width)
                        .css({
                            height: _height,
                        })

                    j++;
                    if (j == countSizeMap) j = 0; // back to top arr
                }
                self.elem.trigger('grid:refresh');
            }
            self._resize.applySize();

            // func getSizeMap
            self._resize.getSizeMap = function() {
                var countItem = self.elem.find(self.opts.itemSelector).length,
                    sizeMap = [];

                for (var i = 0; i <= (countItem - 1); i++) {
                    var _elem = self.elem.find(self.opts.itemSelector).eq(i),
                        _gridSize = _elem.data('grid-size');

                    sizeMap.push([_gridSize[0], _gridSize[1]]);
                }

                return sizeMap;
            }

            // func setSizeMap
            self._resize.setSizeMap = function(sizeMap) {
                if (!sizeMap) return;

                self._resize.opts.sizeMap = sizeMap;
                return this;
            }

            // func resizeHandle (resize item masonry)
            self._resize.resizeHandle = function() {
                if (self._resize.opts.resize == false) return;

                self.elem.find(self.opts.itemSelector).resizable({
                    handles: 'se',
                    start: function() {
                        if ($(this).find('.screen-size').length <= 0) {
                            this.screenSize = $('<span>', { class: 'screen-size' });
                            $(this).append(this.screenSize);
                        } else {
                            this.screenSize = $(this).find('.screen-size');
                        }
                    },
                    resize: function(event, ui) {
                        ui.size.width = ui.size.width + self.opts.space;
                        ui.size.height = ui.size.height + self.opts.space;

                        var pointerItem = this.getBoundingClientRect(),
                            containerWidth = self.elem.width(),
                            celWidth = parseInt((containerWidth / 100) * (100 / self.opts.col));

                        this.step_w = Math.round(ui.size.width / celWidth),
                            this.step_h = Math.round(ui.size.height / self._resize.opts.celHeight);

                        if (this.step_w <= 0) this.step_w = 1;
                        if (this.step_h <= 0) this.step_h = 1;

                        this.screenSize.html(this.step_w + ' x ' + this.step_h);
                    },
                    stop: function(event, ui) {
                        // reset css width/height inline & set item size data
                        $(this).css({
                            width: '',
                            height: '',
                        }).data('grid-size', [this.step_w, this.step_h]);
                        self._resize.opts.sizeMap = self._resize.getSizeMap();
                        self._resize.applySize();
                    }
                });
            }
            self._resize.resizeHandle();

            return self._resize;
        }
        /**
         * End MasonryHybrid
         */

    /* Global Variables */
    var screenRes = $(window).width(),
        screenHeight = $(window).height(),
        innerScreenRes = window.innerWidth, // Screen size width minus scrollbar width
        html = $('html');

    var Bears = {}

    Bears.OffCanvasMenu = function() {
        $('body').on('click', '.menu-item-custom-type-off-cavans-menu > a', function(e) {
            e.preventDefault();
            $(this).parent('li').toggleClass('off-canvas-menu-is-open');
            $('body').toggleClass('body-off-canvas-menu-is-open');
        })

        $('body').on('click', '.off-canvas-menu-closed', function(e) {
            $('.off-canvas-menu-is-open, .body-off-canvas-menu-is-open').removeClass('off-canvas-menu-is-open body-off-canvas-menu-is-open')
        })

        $('body').on('click', '.off-canvas-menu-wrap', function(e) {
            if ($(e.target).hasClass('off-canvas-menu-wrap')) {
                $('.off-canvas-menu-is-open, .body-off-canvas-menu-is-open').removeClass('off-canvas-menu-is-open body-off-canvas-menu-is-open')
            }
        })
    }

    Bears.OffCanvasMenuItemToggle = function() {
        var $items = $('.menu-item-custom-wrap.off-canvas-menu-wrap');

        $items.each(function() {
            var $offcanvas_wrap = $(this);

            $offcanvas_wrap.find('.menu-item-has-children').each(function() {
                var $menu_item = $(this),
                    $toggle_button = $('<div>', { class: 'menu-offcanvas-toggle-ui', 'html': '' });

                $toggle_button.on('click', function(e) {
                    e.preventDefault();

                    $(this).toggleClass('is-open');
                    $menu_item.children('.sub-menu').slideToggle('slow');
                })

                /* append button toggle */
                $menu_item.children('a').append($toggle_button);
            })
        })
    }

    Bears.MenuItemCustom = function() {
        var item_class = [
            '.menu-item-custom-type-search > a', // type search
            '.menu-item-custom-type-sidebar > a', // type sidebar
            '.menu-item-custom-type-woocommerce-mini-cart > a', // type woocommerce-mini-cart
        ];
        $('body').on('click.menuItemCustom', item_class.join(', '), function(e) {
            e.preventDefault();

            //
            if ($(this).parent('li').hasClass('menu-custom-is-active')) {
                $(this).parent('li').removeClass('menu-custom-is-active');
                return;
            }

            // clear all class is active
            $(this).parents('nav.bt-site-navigation').find('.menu-custom-is-active').removeClass('menu-custom-is-active');

            // active this item
            $(this).parent('li').toggleClass('menu-custom-is-active');
        })

        $('div#page').on('click.menuItemCustom', function(e) {
            // alert($(e.target).parents('.menu-custom-is-active').length);
            if ($(e.target).parents('.menu-custom-is-active').length <= 0) {
                $(this).find('.menu-custom-is-active').removeClass('menu-custom-is-active');
            }
        })
    }

    Bears.HeaderSticky = function($opts) {
        this.opts = $.extend({
            header_elem: '',
        }, $opts);

        // check header_elem exist
        if (this.opts.header_elem == '' || this.opts.header_elem.length <= 0) return;

        var self = this;
        self.body = $('body'),
            self.header_absolute = false,
            self.logoContainer = this.opts.header_elem.find('.fw-site-logo'),
            self.header_info = { top: 0, height: 0 };

        // init
        this.init = function() {
            self.header_info = {
                top: self.opts.header_elem.offset().top,
                height: self.opts.header_elem.innerHeight(),
            }

            // check header absolute exist
            self.header_absolute = (self.opts.header_elem.hasClass('fw-absolute-header')) ? true : false;

            // call scrollHandle()
            self.scrollHandle();
        }

        // scroll handle
        this.scrollHandle = function() {
            $(window).on('scroll.HeaderSticky', function(e) {
                var windowTop = $(this).scrollTop();

                if (windowTop >= (self.header_info.top + self.header_info.height)) {
                    // transfrom header stick
                    if (!self.body.hasClass('is-header-sticky')) {
                        self.body.addClass('is-header-sticky');

                        // fix smooth sticky header
                        if (self.header_absolute == false)
                            self.opts.header_elem.parent().height(self.header_info.height);

                        // logo sticky switch
                        self.stickyLogoSwitch(true);
                    }
                } else {
                    // remove header stick
                    if (self.body.hasClass('is-header-sticky')) {
                        self.body.removeClass('is-header-sticky');

                        // fix smooth sticky header
                        if (self.header_absolute == false)
                            self.opts.header_elem.parent().height('auto');

                        // logo sticky switch
                        self.stickyLogoSwitch(false);
                    }
                }
            }).trigger('scroll.HeaderSticky');
        }

        // sticky logo heandle
        this.stickyLogoSwitch = function($sticky_status) {
            if (self.logoContainer.find('.sticky-logo').length <= 0) return;

            if ($sticky_status == true) {
                self.logoContainer.addClass('logo-sticky-is-enable');
            } else {
                self.logoContainer.removeClass('logo-sticky-is-enable');
            }
        }

        // call init()
        this.init();
    }

    Bears.owlCarousel = function() {
        var $owlCarousel_items = $('[data-bears-owl-carousel]');

        $owlCarousel_items.each(function() {
            // options
            var $this = $(this),
                opts = $this.data('bears-owl-carousel');

            try {
                var json_string = window.atob(opts);
                opts = JSON.parse(json_string);
            } catch (e) {
                // something failed

                // if you want to be specific and only catch the error which means
                // the base 64 was invalid, then check for 'e.code === 5'.
                // (because 'DOMException.INVALID_CHARACTER_ERR === 5')
            }

            var opts = $.extend({
                items: 1,
                loop: true,
                margin: 0,
                nav: true,
                navText: ['<i class="ion-ios-arrow-left" title="Previous"></i>', '<i class="ion-ios-arrow-right" title="Next"></i>'],
                URLhashSelector: '',
                // startPosition: window.location.hash.replace('#', ''),
            }, opts);

            $this._once(function() {

                // apply owl carousel
                var owlObject = $(this).owlCarousel(opts);

                owlObject.on('changed.owl.carousel', function(event) {
                    if (opts.URLhashSelector != '') {
                        var URLhash = $(event.target).find(".owl-item").eq(event.item.index).children('.item').data('hash');
                        $(opts.URLhashSelector).removeClass('owl-url-acitive');
                        $(opts.URLhashSelector + '[href="#' + URLhash + '"]').addClass('owl-url-acitive');
                    }
                });

                // saving owlObject
                $(this).data('owl-object', owlObject);
            })
        })
    }

    Bears.Scroll2Element = function($elem, action, minus_space) {
        var $_w = $(window),
            _timeout_resize_key = '',
            top = 0,
            minus_space = (minus_space) ? minus_space : 0,
            e_info = {
                top: $elem.offset().top,
                height: $elem.innerHeight(),
            };

        $elem.on({
            'Scroll2Element:update_info': function(e) {
                e_info = {
                    top: $elem.offset().top,
                    height: $elem.innerHeight(),
                };
            },
            'Scroll2Element:clear_action': function(e) {
                $(this)
                    .off('Scroll2Element:action')
                    .off('Scroll2Element:clear_action')
                    .off('Scroll2Element:update_info')
            },
            'Scroll2Element:action': function(e) {
                if (action) { action.call(this); }
                $elem.trigger('Scroll2Element:clear_action');
            }
        })

        $_w.on({
            'scroll.scroll_to_element': function() {
                top = $_w.scrollTop() + $_w.innerHeight();
                $elem.trigger('Scroll2Element:update_info');

                if (top > e_info.top + minus_space) {
                    $elem.trigger('Scroll2Element:action');
                }
            },
            'resize.scroll_to_element': function() {
                clearTimeout(_timeout_resize_key);

                _timeout_resize_key = setTimeout(function() {
                    $elem.trigger('Scroll2Element:update_info');
                }, 350)
            }
        }).trigger('scroll.scroll_to_element')
    }

    Bears.liquidButton = function() {
        var $liquidButton_items = $('[data-liquid-button]');

        $liquidButton_items._once(function() {
            var self = this;
            self.liquidButton = new LiquidButton(self);
        })
    }

    Bears.progressBarSvg = function() {
        var $progressBarSvg_items = $('[data-progressbar-svg]');

        $progressBarSvg_items._once(function() {
            var $this_elem = $(this);
            var label_position = {
                'top_left': { position: 'absolute', left: '0', top: '0', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(0, -100%)' } },
                'top_center': { position: 'absolute', left: '50%', top: '0', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(-50%, -100%)' } },
                'top_right': { position: 'absolute', right: '0', top: '0', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(0%, -100%)' } },
                'center': { position: 'absolute', left: '50%', top: '50%', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(-50%, -50%)' } },
                'bot_left': { position: 'absolute', left: '0', bottom: '0', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(0, 100%)' } },
                'bot_center': { position: 'absolute', left: '50%', bottom: '0', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(-50%, 100%)' } },
                'bot_right': { position: 'absolute', right: '0', bottom: '0', padding: 0, margin: 0, transform: { prefix: true, value: 'translate(0, 100%)' } },
            };

            var self = this;
            $this_elem.on({
                'progress_bar:get_options': function(e, params, filter) {
                    this._params = $(this).data('progressbar-svg');
                    this._step_action = [];

                    try {
                        var json_string = window.atob(this._params);
                        this._params = JSON.parse(json_string);
                    } catch (e) {
                        // something failed

                        // if you want to be specific and only catch the error which means
                        // the base 64 was invalid, then check for 'e.code === 5'.
                        // (because 'DOMException.INVALID_CHARACTER_ERR === 5')
                    }

                    var self = this;
                    this._opts = $.extend({
                        color: '#00FF85',
                        strokeWidth: 2,
                        trailColor: '#EEEEEE',
                        trailWidth: 1,
                        easing: 'easeInOut',
                        duration: 1400,
                        text: {},
                        from: {},
                        to: {},
                        step: function(state, shape) { return; },
                    }, {
                        color: this._params.color,
                        strokeWidth: parseFloat(this._params.strokeWidth),
                        trailColor: this._params.trailColor,
                        trailWidth: parseFloat(this._params.trailWidth),
                        easing: this._params.easing,
                        duration: parseFloat(this._params.duration),
                    });

                    if (filter) {
                        this._opts = filter.call(this, this._opts, this._params);
                    }

                    return this._opts;
                },
                'progress_bar:step_action': function(e, state, circle) {
                    var step_action = this._step_action;

                    this._opts.step = function(state, shape) {
                        if (step_action.length > 0) {
                            step_action.forEach(function(fn) {
                                fn.call(this, state, shape);
                            })
                        }
                    }
                },
                'progress_bar:circle': function(e, opts, callback) {
                    this._progressBarObj = new ProgressBar.Circle(this, opts);
                    if (callback) callback.call(this, this._progressBarObj);
                },
                'progress_bar:semi_circle': function(e, opts, callback) {
                    this._progressBarObj = new ProgressBar.SemiCircle(this, opts);
                    if (callback) callback.call(this, this._progressBarObj);
                },
                'progress_bar:line': function(e, opts, callback) {
                    this._progressBarObj = new ProgressBar.Line(this, opts);
                    if (callback) callback.call(this, this._progressBarObj);
                },
                'progress_bar:custom': function(e, opts, callback) {
                    this._progressBarObj = new ProgressBar.Path(this, opts);
                    if (callback) callback.call(this, this._progressBarObj);
                },
                'progress_bar:animate': function(e) {
                    var animate_value = (this._params.progressValue / 100).toFixed(2);
                    // new_delay = parseFloat(this._params.delay) + this._opts.duration;

                    // console.log(parseFloat(this._params.delay));
                    this._progressBarObj.set(0);

                    var self = this;
                    setTimeout(function() {
                        self._progressBarObj.animate(animate_value);
                    }, parseFloat(this._params.delay));
                    // this._progressBarObj.animate(animate_value);
                },
                'progress_bar:init': function() {
                    var $elem = $(this);

                    /**
                     * trigger progress_bar:get_options
                     * @ this._params
                     * @ this._opts
                     */
                    $elem.trigger('progress_bar:get_options', [
                        {},
                        function(opts, params) {
                            // console.log(params);
                            /* transform */
                            if (params.animateTransformSettings == 'show') {
                                /* from */
                                opts.from.color = params.color;
                                opts.from.width = parseFloat(params.strokeWidth);

                                /* to */
                                opts.to.color = params.colorTransform;
                                opts.to.width = parseFloat(params.strokeWidthTransform);

                                /* overide strokeWidth (fix display)*/
                                if (opts.to.width > opts.strokeWidth) opts.strokeWidth = opts.to.width;

                                this._step_action.push(function(state, shape) {
                                    shape.path.setAttribute('stroke', state.color);
                                    shape.path.setAttribute('stroke-width', state.width);
                                })
                            }

                            /* text */
                            if (params.textSetings == 'show' && params.shape != 'custom') {
                                opts.text.value = params.label;
                                opts.text.className = 'progressbar__label';

                                var text_style = {};

                                /* set position */
                                switch (params.shape) {
                                    case 'circle':
                                    case 'semi_circle':
                                        /* center */
                                        text_style = label_position.center;
                                        break;

                                    case 'line':
                                        /* top left */
                                        text_style = label_position.top_left;
                                        break;
                                }

                                /* set color */
                                text_style.color = params.text_color;

                                /* apply text style */
                                opts.text.style = text_style;
                                this._step_action.push(function(state, shape) {
                                    // shape.path.setAttribute('stroke', state.color);
                                    // shape.path.setAttribute('stroke-width', state.width);
                                    var value = Math.round(shape.value() * 100);

                                    if (value === 0) { shape.setText(''); } else { shape.setText(params.label.replace('{percent}', value)); }
                                })
                            }

                            /* add step handle */
                            $(this).trigger('progress_bar:step_action');
                            return opts;
                        }
                    ]);

                    var self = this; // console.log(self._opts);
                    $elem.trigger('progress_bar:' + self._params.shape, [self._opts, function(progressSvgObj) {}]);
                    new Bears.Scroll2Element($elem, function(e) { $elem.trigger('progress_bar:animate'); }, 0);
                },
            }).trigger('progress_bar:init')
        })
    }

    Bears.lightgallery = function() {
        var $lightgallery_items = $('[data-bears-lightgallery]');

        $lightgallery_items.each(function() {

            // options
            var opts = $.extend({
                selector: '.item',
                thumbnail: false,
                loadYoutubeThumbnail: true,
                youtubeThumbSize: 'default',
                loadVimeoThumbnail: true,
                vimeoThumbSize: 'thumbnail_medium',
                youtubePlayerParams: {
                    modestbranding: 1,
                    showinfo: 0,
                    rel: 0,
                    controls: 1
                },
                vimeoPlayerParams: {
                    byline: 0,
                    portrait: 0,
                    color: 'A90707',
                }
            }, $(this).data('bears-lightgallery'));

            // apply lightGallery
            var lightGalleryObject = $(this).lightGallery(opts);

            // saving owlObject
            $(this).data('lightgallery-object', lightGalleryObject);
        })
    }

    Bears.MasonryHybrid = function() {
        var $masonryhybrid_items = $('[data-bears-masonryhybrid]');

        $masonryhybrid_items.each(function() {
            var opts = $.extend({
                col: 2,
                space: 30
            }, $(this).data('bears-masonryhybrid'))

            $(this)._once(function() {
                // check grid item exist
                if ($(this).find('.grid-item, .grid-item_, .grid-item__, .grid-item___').length <= 0) return;

                // apply MasonryHybrid
                var grid = new MasonryHybrid($(this), opts);

                // apply resize MasonryHybrid
                if ($(this).data('bears-masonryhybrid-resize')) {
                    var resize_opts = $.extend({
                        celHeight: 180,
                        resize: false,
                    }, $(this).data('bears-masonryhybrid-resize'));

                    // console.log(resize_opts);
                    var gridResize = grid.resize(resize_opts);

                    // save layout handle
                    if (resize_opts.resize == true) Bears.MasonryHybridSaveGridHandle({ grid: grid, gridResize: gridResize });
                }

                // apply filter
                if (opts.filter_selector && $(opts.filter_selector).length > 0) {
                    $(opts.filter_selector).on('click', 'a[data-filter]', function(e) {
                        e.preventDefault();
                        $(this).addClass('is-active').siblings().removeClass('is-active');
                        grid.grid.isotope({ filter: $(this).data('filter') });
                    })
                }
            })
        })
    }

    Bears.MasonryHybridSaveGridHandle = function(obj) {
        var grid_name = obj.grid._resize.opts.grid_name,
            button_save = $('<button type="button" class="save-grid-js" title="save grid layout"><i class="fa fa-spinner fa-spin"></i> Save</button>');

        button_save.on('click', function(e) {
            e.preventDefault();
            var grid_map = obj.gridResize.getSizeMap();

            button_save.addClass('ajax-loading');

            $.ajax({
                type: "POST",
                url: BtPhpVars.ajax_url,
                data: { action: '_alone_save_gridmap_masonryhybrid', params: { gridname: grid_name, gridmap: grid_map } },
                success: function(result) {
                    console.log(result)
                    button_save.removeClass('ajax-loading');
                },
                error: function(e) {
                    alert('Error: ' + JSON.stringify(e) + ' - ' + BtPhpVars.fail_form_error);
                }
            })
        })

        $(obj.grid.elem).append(button_save);
    }

    Bears.countdown = function() {
        var $countdown_items = $('[data-bears-countdown]');

        $countdown_items.each(function() {
            var $this = $(this),
                data = $this.data('bears-countdown'),
                date_end = data.date_end,
                template = data.template;
            // console.log(data);
            $this._once(function() {
                $this.countdown({
                    until: new Date(date_end),
                    format: template,
                });
            })
        })
    }

    // Counter Up
    Bears.counter = function() {
        var $counter_items = $('[data-bears-counterup]');

        $counter_items.each(function() {
            var $this = $(this),
                data = $this.data('bears-counterup'),
                delay = data.delay,
                time = data.time;
            console.log(data);
            $this._once(function() {
                $this.counterUp({
                    delay: delay,
                    time: time
                });
            })
        })
    }

    /**
     * builderElementHandle
     */
    Bears.builderElementHandle = function() {
        var current_url = window.location.href;
        // console.log(current_url);
        /* check is builder mode */
        var cornerstone = current_url.search('cornerstone_preview');
        var visual_composer = current_url.search('vc_editable');
        if (cornerstone + visual_composer < 0) return;

        /* resize window fix element */
        $(window).load(function() {
            // console.log(window.parent.document.getElementsByClassName('cs-preloader').length);
            window.BearsBuilderLoopRenderSuccess = setInterval(function() {
                if (window.parent.document.getElementsByClassName('cs-preloader').length <= 0) {
                    $('body, html').trigger('resize');
                    clearInterval(window.BearsBuilderLoopRenderSuccess);
                }
            }, 2000)
        })

        /* re-call function */
        window.BearsBuilderElementHandle = setInterval(function() {

            /* re-call owlCarousel */
            Bears.owlCarousel();
            /* re-call MasonryHybrid */
            Bears.MasonryHybrid();
            /* re-call Countdown */
            Bears.countdown();

            //counter up
            Bears.counter();
            /* re-call progressBarSvg */
            Bears.progressBarSvg();
        }, 1000)
    }

    Bears.reCallScriptAfterAjax = function() {
        $(document).ajaxComplete(function() {
            /* re-call progressBarSvg */
            setTimeout(function() {
                Bears.progressBarSvg();
                // Bears.liquidButton();
            }, 1000)

        });
    }

    Bears.BacktoTopButton = function() {
        var $button = $('#scroll-to-top-button');
        if ($button.length <= 0) return;

        $button.on('click', function(e) {
            e.preventDefault();

            $('html, body').animate({
                scrollTop: 0
            }, 1000)
        })

        $(window).on('scroll.back_to_top', function() {
            if ($(this).scrollTop() > $(this).height()) {
                if (!$button.hasClass('is-display')) $button.addClass('is-display');
            } else {
                if ($button.hasClass('is-display')) $button.removeClass('is-display');
            }
        })
    }

    Bears.customSelectUi = function() {
        $('select[data-custom-select-ui]').customSelectUi();
        $('.widget_wpurp_recipe_search_widget select').customSelectUi();
        $('.rtb-booking-form select').customSelectUi();
    }

    Bears.FollowScreen = function() {
        var $elements = $('[data-follow-screen]');

        $elements.each(function() {
            var elem = $(this),
                elemInfo = { top: elem.offset().top, height: elem.innerHeight() },
                opts = $.extend({
                    position: 'bottom-right',
                }, elem.data('follow-screen'));

            var close_follow = $('<div>', { class: 'follow-screen-close', 'html': '<i class="fa fa-times" aria-hidden="true"></i>' }).css('display', 'none');
            elem.append(close_follow);

            var elem_shadow = $('<div>', { class: 'followscreen-shadow' }).css('display', 'none');
            elem.after(elem_shadow);

            close_follow.on('click', function(e) {
                e.preventDefault();
                elem.removeClass('followscreen-is-active followscreen-position-' + opts.position).addClass('followscreen-off');
                elem_shadow.css('display', 'none');
            })

            $(window).on({
                'scroll.followscreen': function(e) {
                    if (this.pageYOffset > (elemInfo.top + elemInfo.height) && !elem.hasClass('followscreen-off')) {
                        elem.addClass('followscreen-is-active followscreen-position-' + opts.position);
                        elem_shadow.css({
                            paddingBottom: elemInfo.height,
                            display: 'block',
                        })
                    } else {
                        elem.removeClass('followscreen-is-active followscreen-position-' + opts.position);
                        elem_shadow.css('display', 'none');
                        elemInfo = { top: elem.offset().top, height: elem.innerHeight() };
                    }
                }
            })
        })
    }

    /**
     * ajaxLoadingAnimate
     * @param [obj] $elem
     * @param [string] start | stop
     */
    Bears.ajaxLoadingAnimate = function($elem, $action) {
        var $elem = $elem || $('body'),
            $action = $action || 'start';

        switch ($action) {
            case 'start':
                $elem.addClass('_ajax-loading-animate');
                break;
            case 'stop':
                $elem.removeClass('_ajax-loading-animate');
                break;
        }

        $elem.off('animate:stop', 'animate:start').on({
            'animate:stop': function() {
                Bears.ajaxLoadingAnimate($(this), 'stop');
            },
            'animate:start': function() {
                Bears.ajaxLoadingAnimate($(this), 'start');
            }
        })

        return $elem;
    }

    // event booking handle
    Bears.eventBooking = function() {
        window.eventBooking = window.eventBooking || {};

        window.eventBooking.openBookInfo = window.eventBooking.openBookInfo || function() {
            var hash = window.location.hash.replace('#', '');
            if (hash == '') return;

            $.ajax({
                type: 'POST',
                url: BtPhpVars.ajax_url,
                data: { action: '_fw_ext_event_open_book_info', code: hash },
                success: function(result) {
                    try {
                        var _obj = JSON.parse(result);

                        switch (_obj.book_status) {
                            case 'pending':
                                swal({
                                    title: _obj.heading,
                                    text: _obj.output,
                                    type: _obj.type,
                                    html: true,
                                    confirmButtonText: "Ok",
                                    cancelButtonText: "Cancel",
                                    showCancelButton: true,
                                    closeOnConfirm: false,
                                    showLoaderOnConfirm: true,
                                    customClass: 'fw-ext-event-booking',
                                    animation: false,
                                }, window.eventBooking.bookNow);
                                break;

                            default:
                                swal({
                                    title: _obj.heading,
                                    text: _obj.output,
                                    type: _obj.type,
                                    html: true,
                                });
                                break;
                        }
                    } catch (e) {

                    }

                },
                error: function(e) {
                    console.log(e);
                    swal("!!!", 'Error not defined, Please reload page and try again!', 'error');
                }
            })
        }
        window.eventBooking.openBookInfo();

        window.eventBooking.bookSuccess = window.eventBooking.bookSuccess || function() {
            setTimeout(function() {
                swal({
                    title: "Successful!",
                    text: "...",
                    type: "success",
                });
            }, 2000);
        }

        window.eventBooking.paypal_handle = function(data) {
            window.location.href = data.params.request_url;
        }

        window.eventBooking.bookNow = window.eventBooking.bookNow || function() {
            var data = $('div.fw-ext-event-booking :input[name]').serialize();
            $.ajax({
                type: 'POST',
                url: BtPhpVars.ajax_url,
                data: 'action=_fw_ext_event_booking_now&' + data,
                success: function(result) {
                    var _obj = JSON.parse(result);
                    if (_obj.js_callback) {
                        window.eventBooking[_obj.js_callback].call(this, _obj)
                    } else {
                        swal({
                            title: _obj.heading,
                            text: _obj.output,
                            type: _obj.type,
                            html: true,
                        });
                    }
                },
                error: function(e) {
                    console.log(e);
                    swal("!!!", 'Error not defined, Please reload page and try again!', 'error');
                }
            })
        }

        window.eventBooking.urlAddKeyCode = window.eventBooking.urlAddKeyCode || function(result) {
            var url = location.href.split('#')[0] + '#' + result.bcode;
            window.location.replace(url, "_self");
        }

        window.eventBooking.ajaxBookInfo = window.eventBooking.ajaxBookInfo || function(result, form) {
            // console.log(result);
            swal({
                title: result.heading,
                text: result.output,
                showCancelButton: true,
                confirmButtonText: "Yes, book now!",
                cancelButtonText: "Cancel",
                closeOnConfirm: false,
                // closeOnCancel: false,
                showLoaderOnConfirm: true,
                html: true,
                customClass: 'fw-ext-event-booking',
                animation: false,
            }, window.eventBooking.bookNow);
        }

        $('body').on('submit', '[data-event-booking-form]', function(e) {
            e.preventDefault();
            var booking_form = $(this),
                data = booking_form.serialize();

            // on animate loading ajax
            var $animate_elem = Bears.ajaxLoadingAnimate(booking_form);

            $.ajax({
                type: 'POST',
                url: BtPhpVars.ajax_url,
                data: 'action=_fw_event_booking_get_info&' + data,
                success: function(result) {
                    // off animate loading ajax
                    $animate_elem.trigger('animate:stop');

                    // console.log(result);
                    var result_obj = JSON.parse(result);

                    switch (result_obj.status) {
                        case 200:

                            window.eventBooking.urlAddKeyCode(result_obj);
                            window.eventBooking.ajaxBookInfo(result_obj, booking_form);
                            break;
                        default:
                            if (result_obj.status) {
                                swal(result_obj.heading, result_obj.output, result_obj.type);
                            } else {
                                swal("!!!", 'Error not defined, Please reload page and try again!', 'error');
                            }
                            break;
                    }

                    // $.each(window.eventBooking, function(index, _fn) {
                    // 	_fn(result, booking_form);
                    // })
                },
                error: function(e) {
                    console.log(e);
                    swal("!!!", 'Error not defined, Please reload page and try again!', 'error');
                }
            })
        })
    }

    /**
     * menu mobile default handle (not yet install plg unyson)
     * toggle class "menu-mobi-is-open" to show open menu
     * update May/2/17
     */
    Bears.MenuMobileDefault = function() {
        var el = $('[data-default-menu-mobi-handle]');
        el.each(function() {
            var self = this,
                buttonToggle = $(self).children('.button-toggle-ui'),
                menu = $(self).children('#bt-menu-mobi-menu');

            buttonToggle.on('click', function(e) {
                e.preventDefault();
                $(self).toggleClass('menu-mobi-is-open');
            })
        })
    }

    Bears.sharePost = function() {
        $('body').on('click', '.share-post-wrap a[data-share-post]', function(e) {
            e.preventDefault();

            var href = this.href;
            window.open(href, 'Share', 'width=460,height=380');
        })
    }

    Bears.giveHandle = function() {
        var giveHandle = this;

        // init
        giveHandle.init = function() {
            giveHandle.progress_thinbar_animate();

            return giveHandle;
        }

        /* progress_thinbar_animate */
        giveHandle.progress_thinbar_animate = function() {
            /* data-give-animate-progress-thinbar */
            $('[data-give-animate-progress-thinbar]')._once(function() {
                var $this_elem = $(this),
                    top = 0,
                    info = {
                        value: $this_elem.data('progress-val'),
                        top: $this_elem.offset().top,
                        height: $this_elem.innerHeight(),
                    };

                $this_elem.on({
                    'setDefault': function() {
                        $this_elem.find('.progress-line').css({
                            'opacity': 0,
                            'width': 0
                        });
                    },
                    'runEffect': function() {
                        setTimeout(function() {
                            $this_elem.find('.progress-line').css({
                                'transition': '.6s cubic-bezier(1,.22,.56,.97)',
                                '-webkit-transition': '.6s cubic-bezier(1,.22,.56,.97)',
                                'width': info.value + '%',
                                'opacity': 1,
                            });
                        }, 500)
                    },
                    'clearTrigger': function() {
                        $(this)
                            .off('setDefault')
                            .off('runEffect')
                            .off('scrollHandle')
                            .off('clearTrigger')
                    },
                    'scrollHandle': function(e, _w) {

                        $(this)
                            .trigger('runEffect')
                            .trigger('clearTrigger')
                    }
                }).trigger('setDefault')

                new Bears.Scroll2Element($this_elem, function(e) {
                    $this_elem.trigger('scrollHandle');
                }, 0);

            })
        }

        /* re-acall script after ajax */
        giveHandle.loop = function() {
            $(document).ajaxComplete(function() {
                setTimeout(function() {
                    giveHandle.init();
                }, 1000);
            });
        }

        giveHandle.init().loop();
    }

    Bears.notificationSearchAjax = function() {
        $('body').on('input', 'input[data-search-ajax-result]', function(e) {
            var input = this;

            if (this.value.length >= 2) {
                var interval_input,
                    s = this.value;

                $.ajax({
                    type: 'POST',
                    url: BtPhpVars.ajax_url,
                    data: { action: '_alone_search_data_ajax', search_data: s },
                    success: function(result) {
                        try {
                            var result_obj = JSON.parse(result);

                            if (result_obj.s == input.value) {
                                $(input).closest('.tab-container-search').addClass('tab-container-search-animate');
                                $('#notification-search-ajax-result').html(result_obj.content);
                            }
                        } catch (e) {
                            console.log(e)
                        }
                    },
                    error: function(e) {
                        console.log(e);
                    }
                })
            }
        })
    }

    Bears.notificationCenter = function() {
        var $notificationElem = $('.notification-wrap'),
            $notificationSliderPanel = $('#notification-slider-panel');

        $notificationElem.on({
            do_open: function() {
                $(this).addClass('is-show');
            },
            do_close: function() {
                $(this).removeClass('is-show');
            },
            do_toggle: function() {
                if ($(this).hasClass('is-show')) {
                    $(this).trigger('do_close');
                } else {
                    $(this).trigger('do_open');
                }
            }
        })

        $notificationElem.on('click', '.close-notification', function(e) {
            e.preventDefault();
            $notificationElem.trigger('do_close');
        })

        $('body')
            .on('click', 'a[data-notification]', function(e) {
                // e.preventDefault();
                $notificationElem.trigger('do_open');

                // var $owl_obj = $notificationSliderPanel.data('owl-object'); console.log($owl_obj);
                // if(owl_obj) {
                //
                // }
            })

        window.addEventListener('keydown', function(e) {
            if ((e.key == 'Escape' || e.key == 'Esc' || e.keyCode == 27) && (e.target.nodeName == 'BODY')) {
                $notificationElem.trigger('do_close');
            }
        }, true);
    }

    Bears.init = function() {

        Bears.OffCanvasMenu();

        Bears.OffCanvasMenuItemToggle();

        Bears.MenuItemCustom();

        Bears.MenuMobileDefault();

        Bears.BacktoTopButton();

        // header sticky
        var header_sticky_opts = {
            header_elem: $('.fw-sticky-header').first(),
        }
        new Bears.HeaderSticky(header_sticky_opts);

        // lightgallery
        Bears.lightgallery();

        // MasonryHybrid
        Bears.MasonryHybrid();

        Bears.FollowScreen();

        // owl.Carousel
        Bears.owlCarousel();

        // progressBarSvg
        Bears.progressBarSvg();

        // liquidButton
        Bears.liquidButton();

        // event booking form
        Bears.eventBooking();

        // countdown
        Bears.countdown();

        //counter up
        Bears.counter();

        Bears.customSelectUi();

        window.__GiveDonationsGlobal = new Bears.giveHandle();

        Bears.sharePost();

        /**
         * notification
         */
        Bears.notificationCenter();
        Bears.notificationSearchAjax();

        // builderElementHandle
        Bears.builderElementHandle();

        //
        Bears.reCallScriptAfterAjax();
    }

    /* DOM Ready */
    $(function() {

        jQuery.fn.isOnScreen = function() {
            var win = $(window);
            var viewport = {
                top: win.scrollTop(),
                left: win.scrollLeft()
            };
            viewport.right = viewport.left + win.width();
            viewport.bottom = viewport.top + win.height();

            var bounds = this.offset();
            bounds.right = bounds.left + this.outerWidth();
            bounds.bottom = bounds.top + this.outerHeight();
            return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
        };

        // Animate Things (some online tools for responsive test has 760px)
        if (screenRes > 760 || BtPhpVars.smartphone_animations == 'yes') {
            jQuery(".fw-animated-element").each(function() {
                var animationElement = $(this),
                    delayAnimation = parseInt(animationElement.data('animation-delay')) / 1000,
                    typeAnimation = animationElement.data('animation-type');

                if (animationElement.isOnScreen()) {
                    if (!animationElement.hasClass("animated")) {
                        animationElement.addClass("animated").addClass(typeAnimation).trigger('animateIn');
                    }
                    animationElement.css({
                        '-webkit-animation-delay': delayAnimation + 's',
                        'animation-delay': delayAnimation + 's'
                    });
                }
                $(window).scroll(function() {
                    var top = animationElement.offset().top,
                        bottom = animationElement.outerHeight() + top,
                        scrollTop = $(this).scrollTop(),
                        top = top - screenHeight;

                    if ((scrollTop > top) && (scrollTop < bottom)) {
                        if (!animationElement.hasClass("animated")) {
                            animationElement.addClass("animated").addClass(typeAnimation).trigger('animateIn');
                        }
                        animationElement.css({
                            '-webkit-animation-delay': delayAnimation + 's',
                            'animation-delay': delayAnimation + 's'
                        });
                        // Disable animation fill mode the reason that creates problems,
                        // on hover animation some shortcodes and video full screen in Google Chrome
                        var animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
                        jQuery('.animated').one(animationEnd, function() {
                            $(this).addClass('fill-mode-none');
                        });
                    }
                });
            });
        }

        // use Bears Api
        Bears.init();

        // bootstrap tooltip
        var bootstrapTooltip = function() {
            $('[data-toggle="tooltip"]').tooltip();
        }
        bootstrapTooltip();

        // vimeo frame Api
        function bearsthemes_autoplay_mute_post_layout_creative_vimeo_iframe_api() {
            $('.post-list-type-blog-2').find('.post-video-wrap.video-type-embed').each(function() {
                var iframe = $(this).children('iframe'),
                    src = iframe.attr('src');

                // check is iframe youtube
                if (src.search('vimeo') > 0) {
                    iframe.player = $f(iframe[0]);
                    iframe.player.addEvent('ready', function() {
                        iframe.player.api('play');
                        iframe.player.api('setVolume', 0);
                    })
                }
            })
        }
        bearsthemes_autoplay_mute_post_layout_creative_vimeo_iframe_api();

        // youtube iframe Api
        function bearsthemes_autoplay_mute_post_layout_creative_youtube_iframe_api() {
            $('.post-list-type-blog-2').find('.post-video-wrap.video-type-embed').each(function() {
                var iframe = $(this).children('iframe'),
                    src = iframe.attr('src'),
                    id = 'frame-tube-' + Math.random().toString(36).substring(7);

                // add id
                iframe.attr('id', id);

                // check is iframe youtube
                if (src.search('tube') > 0) {
                    iframe.player = new YT.Player(id, {
                        events: {
                            'onReady': function(event) {
                                iframe.player.mute();
                                iframe.player.playVideo();
                            }
                        }
                    });
                }
            })
        }

        // create tag script
        function load_script_youtube_api_player() {
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];

            var has_include = false;
            $('script').each(function() {
                if (this.src == tag.src) { has_include = true; return false; }
            })

            if (has_include == false) firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        }
        load_script_youtube_api_player();

        window.onYouTubePlayerAPIReady = function() {
            bearsthemes_autoplay_mute_post_layout_creative_youtube_iframe_api();
        };
    })

    /* Window load function */
    $(window).load(function() {

        // Parallax effect function
        function parallaxFn(event) {
            $.stellar({
                responsive: false,
                horizontalScrolling: false,
                // positionProperty: 'transform',
            });
        }

        parallaxFn();
    })
})(jQuery)
