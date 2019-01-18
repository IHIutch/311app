<footer class="footer py-3 bg-grey mt-5">
    <div class="container text-center">
        <span class="text-muted">Buffalo 311</span>
    </div>
</footer>

<div class="modal fade" id="warning" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="border-bottom mb-3">
                    <p class="text-center display-2 mb-0">👋</p>
                    <h2 class="text-center display-4">Welcome!</h2>
                </div>
                <p>This site is a small passion project and beta test of a more usable and transparent 311 system. Go ahead and try fill out a report, see what you think, and leave some feedback! </p>
                <p>If you have a legitimate 311 issue, please report it at the <a href="https://www.buffalony.gov/463/311-Call-Resolution-Center">311 Call &amp; Resolution Center</a>.</p>
                <p class="mb-0 small text-muted text-center">This site is a work in progress and will continue to change. You may experience bugs.</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="warningClose" class="btn btn-primary m-auto" data-dismiss="modal">I understand</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //if cookie hasn't been set...
        if (document.cookie.indexOf("ModalShown=true") < 0) {
            $("#warning").modal("show");
            //Modal has been shown, now set a cookie so it never comes back
            $("#warningClose").click(function() {
                document.cookie = "ModalShown=true; expires=Fri, 31 Dec 9999 23:59:59 GMT; path=/";
            });
        }
    });
</script>



<script>
    $(function() {
        'use strict'
        $('[data-toggle="offcanvas"]').on('click', function() {
            $('.offcanvas-collapse').toggleClass('open')
        })
    })

</script>

</body>

</html>
