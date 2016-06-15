jQuery(document).ready(function($) {
	$('a').each(function () {
		 var url = $(this).attr("href");
		 var host=get_hostname(url);

		 hostname = new RegExp(location.host);
		  // Test if current host (domain) is in it
            if(hostname.test(url) || host==null ){
               // If it's local...
               $(this).addClass('local');
            }
            else {

               $(this).addClass('external');  
               $(this).leaveNotice({siteName:sitename,timeOut:7000});                      
            }
		});
});
function get_hostname(url) {
    var m = url.match(/^http:\/\/[^/]+/);
    return m ? m[0] : null;
}
