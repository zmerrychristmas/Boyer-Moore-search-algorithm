<!DOCTYPE html>
<html>
    <head>
        <title>
            The text search
        </title>
        <link href="style.css" type='text/css' rel="stylesheet" />
        <script type="text/javascript" src="jquery-3.1.1.min.js"></script>
    </head>
    <body>
        <header>
            <h3>The Test Search</h3>
        </header>
        <section class="search-warpper wrapper" id="main-content">
            <div class="form-wraper">
                <form action="server.php" method="POST">
                    <div class="form-group">
                        <label for="sub-string">Sub string:</label><span class="hidden alert" id="sub-string-alert"></span>
                        <input type="text" id="sub-string" name="sub-string" />
                    </div>
                    <div class="form-group">
                        <label for="main-string">Main string:</label><span class="hidden alert" id="main-string-alert"></span>
                        <textarea id="main-string" name="main-string" rol="40" cols="30" ></textarea>
                    </div>
                    <button type="submit" class='btn' id="search" name="search" value="search">Search!</button>
                </form>
            </div>
        </section>
        <section class="search-wrapper wrapper" id="search-result">
            <p>SubText:<span class="bold" id="input-preview"><strong></strong></span></p><hr />
            <p>OutPut:<span class="bold" id="output-preview"><strong></strong></span></p>
        </section>
        <script>
        $(document).ready(function() {
            $('#search').on('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                var sub_string = $('#sub-string').val();
                if (sub_string == '') {
                    $('#sub-string-alert').removeClass('hidden');
                    $('#sub-string-alert').text('(Enter input sub string)');
                }

                var main_string = $('#main-string').val();
                if (main_string == '') {
                    $('#main-string-alert').removeClass('hidden');
                    $('#main-string-alert').text('(Enter input main string)');
                    return;
                }
                $('#search').prop('disabled', true);
                $('.alert').addClass('hidden');
                if (sub_string != '' && main_string != '') {
                    // search
                    $.ajax({
                            url: "server.php",
                            type: "post",
                            data: {
                                search: 'search',
                                'sub-string': sub_string,
                                'main-string': main_string
                            },
                            dataType: 'JSON',
                            success: function(data) {
                                $('#search').prop('disabled', false);
                                var out_put = data.index;
                                $('#input-preview').text(sub_string);
                                out_put.length > 0 ? $('#output-preview').text(out_put.join()) : $('#output-preview').text('<No matches>');
                            },
                            error: function(data) {
                                alert('Error: ' + data);
                                $('#search').prop('disabled', false);
                            }
                    });
                }
            });
        })
        </script>
    </body>
</html>
