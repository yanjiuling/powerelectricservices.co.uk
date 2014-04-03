jQuery(function($) {
var open = false;

function resizeMenu() {
if ($(this).width() < 768) {
if (!open) {
$("#menu").hide();
}
$("#menu-button").show();
$("#logo").attr("src", "images/logo.jpg");
}
else if ($(this).width() >= 768) {
if (!open) {
$("#menu").show();
}
$("#menu-button").hide();
$("#logo").attr("src", "images/logo.jpg");
}
}

function setupMenuButton() {
$("#menu-button").click(function(e) {
e.preventDefault();

if (open) {
$("#menu").fadeOut();
$("#menu-button").toggleClass("selected");
}
else {
$("#menu").fadeIn();
$("#menu-button").toggleClass("selected");
}
open = !open;
});
}


$(window).resize(resizeMenu);

resizeMenu();
setupMenuButton();

$(".zoom").fancybox({
padding: 5
});


$(".sec-nav ul li a.arrow").click(function(){
if($(this).hasClass("expand"))
{
$(this).removeClass("expand");
$(this).addClass("contract");
$(this).siblings("ul").slideDown(500);
}
else if($(this).hasClass("contract"))
{
$(this).removeClass("contract");
$(this).addClass("expand");
$(this).siblings("ul").slideUp(500);
}
return false;
});

//Mobile services nav
$(".nav_control").click(function(){
$(this).toggleClass("open");
$(".services_container").slideToggle("500");
return false;
});

$(".blog-post").fitVids();

});