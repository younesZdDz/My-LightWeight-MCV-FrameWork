<?php $this->setSiteTitle('Login') ?>
<?php $this->start('head') ?>
<meta content="Login Page" >
<?php $this->end() ?>
<?php $this->start('body') ?>
<div class="col-md-6 offset-md-3 well">
  <form class="form" method="POST" action="">
    <div class="bd-danger"><?= $this->displayErrors ?></div>
    <h3 class="text-center">Log In</h3>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" name="username" id="username" class="form-control"/>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" name="password" id="password" class="form-control"/>
    </div>
    <div class="form-group">
      <label for="remember_me">Remember me <input type="checkbox" name="remember_me" id="remember_me" value="on"/></label>
    </div>
    <div class="form-group">
      <input type="submit" value="Login" class="btn-large btn btn-primary" />
    </div>
    <div class="text-right">
      <a href="" class="text-primary">Register</a>

    </div>
  </form>
</div>
<?php $this->end() ?>
