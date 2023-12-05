<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
    <title>Template Pembatalan Transaksi</title>
    <style>
        .title {
            text-align: center;
        }
        .text {
            text-align: justify;
        }
    </style>
</head>

<body>
    <div>
        <embed src="{{ asset('template/surat_kesepakatan_pembatalan_transaksi.pdf') }}" width="100%" height="1200px" type='application/pdf' download='surat_kesepakatan_pembatalan_transaksi.pdf'>
    </div>
</body>

</html>