window.addEvent('domready', function() {
	document.formvalidator.setHandler('product_name',
		function (value) {
			//regex=/^[^0-9]+$/;
			//return regex.test(value);
			return true;
	});
});