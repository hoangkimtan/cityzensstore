<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('dist/toast.min.css') }}">
</head>

<body>
    <div class="container">
        <h1 class="text-center">
            Toast
        </h1>
        <button class="btn btn-primary">
            Click
        </button>
    </div>

 
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="{{ asset('dist/toast.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            $('.btn.btn-primary').on('click',function(){
                $.toast({
                type: "success",
                title: "Thông báo",
                subtitle: 'Now',
                content: "Bạn có đơn hàng mới từ",
                delay: 100000000,
                img: {
                    src: 'https://via.placeholder.com/20',
                    alt: 'Image'
                }
            });
            })
        })
    </script>
</body>

</html>
