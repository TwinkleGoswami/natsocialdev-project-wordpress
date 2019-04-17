jQuery('#change-profile-pic').on('click', function(e){
jQuery('#profile_pic_modal').modal({show:true});
});

jQuery('#profile-pic').on('change', function() {
jQuery("#preview-profile-pic").html('');
jQuery("#preview-profile-pic").html('Uploading....');
$("#cropimage").ajaxForm(
{
target: '#preview-profile-pic',
success: function() {
jQuery('img#photo').imgAreaSelect({
aspectRatio: '1:1',
onSelectEnd: getSizes,
});
$('#image_name').val($('#photo').attr('file-name'));
}
}).submit();
});

jQuery('#save_crop').on('click', function(e){
e.preventDefault();
params = {
targetUrl: 'change_pic.php?action=save',
action: 'save',
x_axis: jQuery('#hdn-x1-axis').val(),
y_axis : jQuery('#hdn-y1-axis').val(),
x2_axis: jQuery('#hdn-x2-axis').val(),
y2_axis : jQuery('#hdn-y2-axis').val(),
thumb_width : jQuery('#hdn-thumb-width').val(),
thumb_height:jQuery('#hdn-thumb-height').val()
};
saveCropImage(params);
});

function saveCropImage(params) {
jQuery.ajax({
url: params['targetUrl'],
cache: false,
dataType: "html",
data: {
action: params['action'],
id: jQuery('#hdn-profile-id').val(),
t: 'ajax',
w1:params['thumb_width'],
x1:params['x_axis'],
h1:params['thumb_height'],
y1:params['y_axis'],
x2:params['x2_axis'],
y2:params['y2_axis'],
image_name :jQuery('#image_name').val()
},
type: 'Post',
success: function (response) {
jQuery('#profile_pic_modal').modal('hide');
jQuery(".imgareaselect-border1,.imgareaselect-border2,.imgareaselect-border3,.imgareaselect-border4,.imgareaselect-border2,.imgareaselect-outer").css('display', 'none');
jQuery("#profile_picture").attr('src', response);
jQuery("#preview-profile-pic").html('');
jQuery("#profile-pic").val();
},
error: function (xhr, ajaxOptions, thrownError) {
alert('status Code:' + xhr.status + 'Error Message :' + thrownError);
}
});
}