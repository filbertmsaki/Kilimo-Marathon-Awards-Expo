var options = {
	title: '&#x1F36A; Accept Cookies & Privacy Policy?',
	message: 'There are no cookies used on this site, but if there were this message could be customised to provide more details. Click the <strong>accept</strong> button below to see the optional callback in action...',
	delay: 600,
	expires: 1,
	link: '#privacy',
	onAccept: function(){
		var myPreferences = $.fn.ihavecookies.cookie();
		console.log('Yay! The following preferences were saved...');
		console.log(myPreferences);
	},
	uncheckBoxes: true,
	acceptBtnLabel: 'Accept Cookies',
	moreInfoLabel: 'More information',
	cookieTypesTitle: 'Select which cookies you want to accept',
	fixedCookieTypeLabel: 'Essential',
	fixedCookieTypeDesc: 'These are essential for the website to work correctly.'
}

$(document).ready(function() {
	$('body').ihavecookies(options);

	if ($.fn.ihavecookies.preference('marketing') === true) {
		console.log('This should run because marketing is accepted.');
	}

	$('#ihavecookiesBtn').on('click', function(){
		$('body').ihavecookies(options, 'reinit');
	});
});