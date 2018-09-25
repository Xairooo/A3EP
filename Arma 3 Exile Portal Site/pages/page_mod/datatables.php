    <style>
        .chosen-container {
            width: 100% !important;
        }

        .text_button {
            border: none;
            background-color: transparent;
            padding: 0;
        }
    </style>
    <script src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#tableList').DataTable({
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],
                "columnDefs": [{
                    "orderSequence": ["desc", "asc"],
                    "targets": [1, 2, 3, 4]
                }]
            });
            table
                .order([0, 'desc'])
                .draw();
        });
    </script>