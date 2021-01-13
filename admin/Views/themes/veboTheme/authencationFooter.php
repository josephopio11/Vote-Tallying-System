<?php
$locale = service('request')->getLocale(); 
$resourcesUrl = resources_url();
?>

<!-- Bootstrap core JavaScript-->
<script src="<?=$resourcesUrl;?>jquery/jquery-3.4.1.min.js"></script>
<script src="<?=$resourcesUrl;?>bootstrap/4.4.1/js/bootstrap.min.js"></script>
<!-- Core plugin JavaScript-->
<script src="<?=$resourcesUrl;?>jquery-easing/1.4.1/jquery.easing.min.js"></script>

<!-- sweetalert  -->
<script src="<?=$resourcesUrl;?>sweatalert2/9.8.2/sweetalert2.all.min.js"></script>

<!-- CRUD4 js file -->
<script src="<?=$resourcesUrl;?>general.js"></script>

</body>

</html>