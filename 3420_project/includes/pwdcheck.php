<ul class="lead list-group" id="requirements">
    <li id="length" class="list-group-item">At least 8 characters</li>
    <li id="lowercase" class="list-group-item">At least 1 lowercase letter</li>
    <li id="uppercase" class="list-group-item">At least 1 uppercase letter</li>
    <li id="number" class="list-group-item">At least 1 numerical number</li>
    <li id="special" class="list-group-item">At least 1 special character</li>
</ul>
<div class="error" <?= !isset($errors['pwd']) ? 'hidden' : ""; ?>>Please enter a password</div>
<div class="error" <?= !isset($errors['pwdweak']) ? 'hidden' : ""; ?>>Password does not follow all the conditions given above</div>