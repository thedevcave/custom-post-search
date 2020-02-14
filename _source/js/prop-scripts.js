/************************************************************************/
/* SCRIPTS
/************************************************************************/
//@codekit-prepend "_plugins.js", "_functions.js";

jQuery(document).ready(function($) {
	
	heroAnimation();
	floatingLabels();
	initCarousels();
	floorplans();
	sendInfoOverlay();
	stayInTouchBuilderEmails(); 
	gridInit();
	backToGridHash();
	mobileGridToggle();
	builderPopupForm();
	
});

jQuery(window).load(function($){
	gridInit();
});