	<?php View::renderScripts(
						SCRIPT_PATH, 
						array(
							'bootstrap.min.js',
							'bootstrap.js',
							'npm.js')); ?>
    <script>
		$('li.dropdown').click(function() {
			$("ul.dropdown-mvc", this).slideToggle('fast');
			$('a>i.chevronInSidebar', this).toggleClass('fa-chevron-down').toggleClass('fa-chevron-up');
			$(this).toggleClass('active');
		});
		$(function () {
  			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
</body>
</html>