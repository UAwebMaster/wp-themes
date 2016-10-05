<?php
/**
 * Created by JetBrains PhpStorm.
 * User: slavik
 * Date: 09.12.15
 * Time: 10:13
 * To change this template use File | Settings | File Templates.
 */
?>
</div>
</div>
</div>
</div>
</div>


<script type="text/javascript">
    $(document).ready(function () {


        $('#users').DataTable({
            "pageLength": 100,
            "language": {
                "lengthMenu": "Виводити _MENU_ записів на сторінку",
                "zeroRecords": "Nothing found - sorry",
                "info": "Showing page _PAGE_ of _PAGES_",
                "infoEmpty": "No records available",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": "Пошук:"
            }
        });

    })
</script>
