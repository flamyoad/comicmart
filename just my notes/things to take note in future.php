<html>
<!-- href="javascript:void(0)" is needed for AJAX to work.. 
     Otherwise clicking on the <a> will refresh the whole page to its original content
     a split second after the AJAX request,
     thus making it look like the AJAX request did not replace the section -->
<li data-content="account-settings-library.php">
    <a href="javascript:void(0)">
        <i class="fa fa-book nav-icons" aria-hidden="true"></i>
        <span>Library</span>
    </a>
</li>

<script>
    $(document).ready(function() {

        $("nav li").click(function() {
            $.ajax({
                type: "GET",
                url: $(this).data("content"), // eg account-settings-library.php
                dataType: "html",
                success: function(response) {
                    $("#section").replaceWith(response);
                }
            })
        });

    })
</script>

</html>


2. Also don't include jQuery twice........