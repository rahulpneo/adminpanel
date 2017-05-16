<html>
<body>
<!--<a href="#" id="dntrigger">Notification</a>-->
<h1>Server Notification</h1>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<!-- Notifikasi Script -->
	
<script type ="text/javascript">
$(document).ready(function() { 
		checknotif();
	setInterval(function(){ checknotif(); }, 5000);
});
function checknotif() {
if (Notification.permission != "granted"){
		Notification.requestPermission();
	}else {
		
						var notifikasi = new Notification('new message from alex', {
							icon: '',
							body: 'how are you',
						});
						notifikasi.onclick = function () {
							window.open('http://localhost:8000/admin/articles'); 
							notifikasi.close();     
						};
						setTimeout(function(){
							notifikasi.close();
						}, 3000);
					

	}
};
</script>

</body>
</html>
