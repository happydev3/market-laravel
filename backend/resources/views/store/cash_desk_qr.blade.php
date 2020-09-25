<html>
    <head>
        <link rel="stylesheet" href="{{URL::to('css/style.css')}}">
        <title>Il tuo codice QR</title>
    </head>

    <body style="background: white">
    <div align="center">
        <br/>
        <br/>
        <input type="hidden" value="{{$deskCode}}" id="deskCode">
        <img src="{{URL::to('images/mail_logo.png')}}">
        <h3 style="{padding: 10px; color:black;}">Inquadra questo QR <br/> con l'app di Freeback</h3> <br/>
        <div style="{padding: 15px;}" id="qr"></div> <br/>
        <h3 align="center">{{$deskCode}}</h3>
        <br/>
        <h3 align="center">Visita freeback.it e scarica l'App, <br/>  ottieni Cashback instantaneo <br/> nei Negozi convenzionati.</h3>
        <br/>
        <button id="printBtn" class="button big dark">@lang('store_panel.print_qr_code')</button>
    </div>

    <script src="{{URL::to('js/vendor/jquery-3.1.0.min.js')}}"></script>
    <script src="{{URL::to('js/vendor/qrcode.min.js')}}"></script>
    <script>
        var qrCode = new QRCode('qr');
        qrCode.makeCode($('#deskCode').val());

        $('#printBtn').click(function(){
            $('#printBtn').hide();
            window.print();
        });
    </script>
    </body>
</html>