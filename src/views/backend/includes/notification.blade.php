<script>
$(document).ready(function() {
    // Apply the plugin to the body 
   $('.page-container').pgNotification({
   	message: "{{ session('notification') }}",
   	position: 'bottom-right',
   	timeout: 8000
   }).show();
});
</script>