<link href="/styles/style.css" rel="stylesheet" type="text/css">

<form class="forms" style="margin-left: 200px; margin-right: 200px" action="index.php?page=contacts" method="POST" >

    <h1 style="text-align: center; padding-block-end: 20px">Contact US</h1>

    <div class="form-group">
        <label for="name">Name: </label>
        <input type="text" class="form-control" name="name" id="name" value="<?= OldInputs::get('name')?>">
    </div>

    <div class="form-group mt-3">
        <label for="email">Email: </label>
        <input type="email" class="form-control" name="email" id="email" value="<?= OldInputs::get('email')?>">
    </div>

    <div class="form-group mt-3">
        <label for="message">Message: </label>
        <textarea class="form-control" name="message" id="message"><?= OldInputs::get('message')?></textarea>
    </div>

    <button class="btn btn-primary mt-3" name="action" value="sendMail">Send</button>

    <?php
    Message::get();
    ?>


</form>
