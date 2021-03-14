
<script type="text/javascript" src="<?= base_url() ?>assets/js/jquery-min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

    <?php if($this->session->flashdata('error')) : ?>
        <script>
            iziToast.show({
            title: 'Error :',
            message: '<?= $this->session->flashdata('error') ?>',
            timeout: 60000,
            theme: 'dark',
            position: 'bottomRight',
            backgroundColor: '#ff5050',
        });
        </script>
    <?php endif; ?>

    <?php if($this->session->flashdata('success')) : ?>
        <script>
            iziToast.show({
            title: 'Success :',
            message: '<?= $this->session->flashdata('success') ?>',
            timeout: 60000,
            theme: 'dark',
            position: 'bottomRight',
            backgroundColor: '#23e869'
        });
        </script>
    <?php endif; ?>

     <script>
            $(document).ready( function () {
                $('#myTable').DataTable();
            } );
        </script>

</body>
</html>