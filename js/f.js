// Set the original/default language
var lang = "en";
var currentClass = "currentLang";

// Load the language lib
google.load("language",1);

// When the DOM is ready....
window.addEvent("domready",function(){
	// Retrieve the DIV to be translated.
	var translateDiv = document.id("languageBlock");
	// Define a function to switch from the currentlanguage to another
	var callback = function(result) {
		if(result.translation) {
			translateDiv.set("html",result.translation);
		}
	};
	// Add a click listener to update the DIV
	$$("#languages a").addEvent("click",function(e) {
		// Stop the event
		if(e) e.stop();
		// Get the "to" language
		var toLang = this.get("rel");
		// Set the translation into motion
		google.language.translate(translateDiv.get("html"),lang,toLang,callback);
		// Set the new language
		lang = toLang;
		// Add class to current
		this.getSiblings().removeClass(currentClass);
		this.addClass(currentClass);
	});
});