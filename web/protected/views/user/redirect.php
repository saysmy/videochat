<script>
if (window.opener) {
    window.opener.location.reload();
    window.close();
}
else {
    location.href = '<?=$redirect_url?>';
}
</script>