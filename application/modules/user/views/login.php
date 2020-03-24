<div class="content max-sm-container">
    <div class="content-body">
        <div class="py-3 py-md-5">
            <div class="col-md-10 col-lg-9 mx-auto">
                <?php echo $message; ?>
                <?php echo $errors; ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h2 class="pt-3 pb-2">Account Login</h2>
                        <form class="mb-2" method="post">
                            <?php if (isset($go)): ?>
                                <input type="hidden" value="<?php echo $go ?>" name="go">
                            <?php endif ?>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" autofocus="" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                            </div>
                            <div class="form-group pt-2">
                                <button type="submit" class="btn btn-lg btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>