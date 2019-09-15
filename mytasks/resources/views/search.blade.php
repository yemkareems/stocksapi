<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
</head>
<body>

<div class="container">
    <h1>Get your fav stock quote</h1>
    <input class="typeahead form-control" type="text">
</div>

<script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    $('input.typeahead').typeahead({
        display: ['symbol'],
        source:   {

            url: path
        }
    });
</script>


<script>

    $('input.typeaheadkkkk').typeahead({
        minLength: 1,
        order: "asc",
        dynamic: true,
        delay: 500,
        backdrop: {
            "background-color": "#fff"
        },
        template: function (query, item) {

            var color = "#777";

            return '<span class="row">' +
                '<span class="username">@{{name}} <small style="color: ' + color + ';">(@{{name}})</small></span>' +
                '<span class="id">(@{{symbol}})</span>' +
                "</span>"
        },
        emptyTemplate: "no result for @{{query}}",
        source: {
            user: {
                display: "username",
                href: "http://www.github.com/@{{symbol|slugify}}",
                data: [{
                    "symbol": "an inserted user that is not inside the database",
                    "name": "https://avatars3.githubusercontent.com/u/415849"
                }],
                ajax: function (query) {
                    return {
                        type: "GET",
                        url: path,
                        data: {
                            q: "@{{query}}"
                        },
                        callback: {
                            done: function (data) {
                                alert(data);
                                for (var i = 0; i < data.data.length; i++) {
                                    if (data.data[i].username === 'running-coder') {
                                        data.data.user[i].status = 'owner';
                                    } else {
                                        data.data.user[i].status = 'contributor';
                                    }
                                }
                                return data;
                            }
                        }
                    }
                }

            },
            project: {
                display: "project",
                href: function (item) {
                    return '/' + item.project.replace(/\s+/g, '').toLowerCase() + '/documentation/'
                },
                ajax: [{
                    type: "GET",
                    url: "/jquerytypeahead/user_v1.json",
                    data: {
                        q: "@{{query}}"
                    }
                }, "data.project"],
                template: '<span>' +
                    '<span class="project-logo">' +
                    '<img src="@{{image}}">' +
                    '</span>' +
                    '<span class="project-information">' +
                    '<span class="project">@{{project}} <small>@{{version}}</small></span>' +
                    '<ul>' +
                    '<li>@{{demo}} Demos</li>' +
                    '<li>@{{option}}+ Options</li>' +
                    '<li>@{{callback}}+ Callbacks</li>' +
                    '</ul>' +
                    '</span>' +
                    '</span>'
            }
        },
        callback: {
            onClick: function (node, a, item, event) {

                // You can do a simple window.location of the item.href
                alert(JSON.stringify(item));

            },
            onSendRequest: function (node, query) {
                console.log('request is sent')
            },
            onReceiveRequest: function (node, query) {
                console.log('request is received')
            }
        },
        debug: true
    });

</script>


</body>
</html>