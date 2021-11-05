<script>
$(document).ready(function() {
    // Apply the plugin to the body 
   $('.page-container').pgNotification({
   	message: "{{ session('whoops') }}",
   	position: 'bottom-right',
   	type: 'warning',
   	timeout: 8000
   }).show();
});
</script>