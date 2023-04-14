<link href="/styles/style.css" rel="stylesheet" type="text/css">

<form class="forms" action="index.php?page=login" method="POST">

    <h1 style="text-align: center; padding-block-end: 20px">Registration</h1>

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>

    <div class="form-group mt-3">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
    </div>

    <div class="form-group mt-3">
        <label for="password">Password</label>
        <input type="password" class="form-control" name="password" id="password" required>
    </div>

    <button class="btn btn-primary mt-3" name="action" value="sendRegisterInfo">Register</button>

</form>
