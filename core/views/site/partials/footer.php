    <script>let BASE_URL = "<?=BASE_URL?>"</script>
    <script src="<?=BASE_URL?>/assets/js/menu.js"></script>
    <script src="<?=BASE_URL?>/assets/js/scrollPage.js"></script>

    <?php if(@$_GET["url"] !== "contact" && @$_GET["url"] !== "blog" && @$_GET["url"] !== "post"): ?>
        <script src="<?=BASE_URL?>/assets/js/slider.js"></script>
    <?php endif; ?>
</body>
</html>