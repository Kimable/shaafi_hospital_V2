<!DOCTYPE html>
<html>
    <head>
        <title>Delete Email</title>
    </head>
    <body>
        <h2>Hello {{ $data["name"] }}</h2>
        <p>
            Are you sure you want to delete your account: {{ $data["email"] }}?
        </p>
        <a
            style="
                display: inline-block;
                padding: 15px;
                background-color: red;
                color: white;
                text-decoration: none;
                text-align: center;
                text-transform: uppercase;
                font-weight: 700;
            "
            href="http://127.0.0.1:8000/delete?email={{ $data['email'] }}"
            >Yes, I am sure</a
        >
    </body>
</html>
