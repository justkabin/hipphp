{*@package HipPhp*}
{*@author     Shane Barron <admin@hipphp.com>*}
{view name="page_elements/foot"}
{footerjs}
{view name="page_elements/js_init"}
{if footerscript}
    <script>
        {footerscript}
    </script>
{/if}
</body>
</html>