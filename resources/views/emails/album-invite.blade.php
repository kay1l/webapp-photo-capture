<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Album Invite</title>
</head>
<body style="font-family: sans-serif; padding: 20px;">
    <h2>You’ve been invited to a photo album!</h2>
    <p>Click the link below to view the album:</p>

    <p>
        <a href="{{ $url }}" style="display:inline-block; padding:10px 15px; background:#3490dc; color:white; text-decoration:none; border-radius:4px;">
            View Album
        </a>
    </p>

    <p>If the button doesn’t work, here’s the link:</p>
    <p><a href="{{ $url }}">{{ $url }}</a></p>

    <hr>
    <p style="color:#777;">This link gives you access to the album in view-only mode.</p>
</body>
</html>
