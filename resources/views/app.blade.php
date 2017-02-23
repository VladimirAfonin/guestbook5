<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Guestbook5</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    @yield('content')
</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script type="text/javascript">
// admin edit data.
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').addClass('glyphicon-check').removeClass('glyphicon-trash').text(' Update');
        $('.actionBtn').addClass('btn-success edit').removeClass('btn-danger');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#fid').val($(this).data('id'));
        $('#n').val($(this).data('name'));
        $('#c').val($(this).data('comment'));
        $("#myModal").modal('show');
    });

    $('.modal-footer').on('click', '.edit' ,function() {
        $.ajax({
            type: 'post',
            url: '/admin/editItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'id': $('#fid').val(),
                'name': $('#n').val(),
                'text': $('#c').val()
            },
            success:function(data) {
                $(".item" + data.id).replaceWith("<tr class='item" + data.id + "'><td>" + "</td><td>" + data.name + "</td><td><textarea class='form-control' rows='4'>" + data.text + "</textarea></td><td><button class='edit-modal btn btn-primary' data-id='" + data.id + "' data-name='" + data.name + "' data-comment='" + data.text + "'><span class='glyphicon glyphicon-edit'> </span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' data-comment='" + data.text + "'><span class='glyphicon glyphicon-trash'> </span> Delete</button> </td> </tr>");
            }
        });
    });

    // admin delete data.
    $(document).on('click', '.delete-modal', function() {
       $('#footer_action_button').addClass('glyphicon-trash').removeClass('glyphicon-check').text(' Удалить');
       $('.actionBtn').addClass('btn-danger delete').removeClass('btn-success');
       $('.modal-title').text('Delete');
       $('.deleteContent').show();
       $('.form-horizontal').hide();
       $('.id, .title').text($(this).data('id'));
       $("#myModal").modal('show');
    });

    $('.modal-footer').on('click', '.delete', function() {
       $.ajax({
           type: 'post',
           url: '/admin/deleteItem',
           data: {
               '_token': $('input[name=_token]').val(),
               'id': $('.id').text()
           },
           success:function(data) {
               $('.item' + $('.id').text()).remove();
           }
       });
    });

    // admin add data.
    $('#add').click(function() {
        $.ajax({
            type: 'post',
            url: '/addItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'name': $('input[name=name]').val(),
                'email': $('input[name=email]').val(),
                'text': $('textarea[name=text]').val()
            },
            success: function(data) {
                if(data.errors) {
                    if(data.errors.email) {
                        $('.erroremail').removeClass('hidden').text(data.errors.email);
                    } else {
                        $('.erroremail').addClass('hidden').text('');
                    }
                    if(data.errors.text) {
                        $('.errortext').removeClass('hidden').text(data.errors.text);
                    } else {
                        $('.errortext').addClass('hidden').text('');
                    }
                } else {
                    $('.erroremail .errortext').addClass('hidden').text('');
                    $('#table').append("<tr class='item" + data.id + "'><td>" + data.id + "</td><td>" + data.name + "</td><td><textarea class='form-control' rows='4'>" + data.text + "</textarea></td><td><button class='edit-modal btn btn-primary' data-id='" + data.id + "' data-name='" + data.name + "' data-comment='" + data.text + "'><span class='glyphicon glyphicon-edit'> </span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.id + "' data-name='" + data.name + "' data-comment='" + data.text + "'><span class='glyphicon glyphicon-trash'> </span> Delete</button> </td> </tr>");
                    $('#text').text('');
                }
            }
        });
    });
// user add data.
$("#useradd").click(function() {
    $.ajax({
        type:'post',
        url: '/addItem',
        data: {
            '_token': $('input[name=_token]').val(),
            'name': 'Guest',
            'email': $('input[name=email]').val(),
            'text': $('textarea[name=text]').val()
        },
        success: function(data) {
            if(data.errors) {
                if(data.errors.email) {
                    $('.erroremail').removeClass('hidden');
                    $('.erroremail').text(data.errors.email);
                } else {
                    $('.erroremail').addClass('hidden').text('');
                }
                if(data.errors.text) {
                    $('.errortext').removeClass('hidden');
                    $('.errortext').text(data.errors.text);
                } else {
                    $('.errortext').addClass('hidden').text('');
                }
            } else {
                $('.erroremail, .errortext').addClass('hidden').text('');
                $('.msg').fadeIn();
                setTimeout(function() { $('.msg').fadeOut('slow') }, 4000);
                $('.table').append("<div class='panel panel-default item'" + data.id + "'><div class='panel-heading'><h2 class='panel-title'><small>" + data.name + "</small><span class='pull-right label label-info'>" + "a few seconds ago" + "</span></h2></div><div class='panel-body'>" + data.text + "</div></div>");
                $('#comment').text('');
            }
        }
    });
});



</script>


</body>
</html>