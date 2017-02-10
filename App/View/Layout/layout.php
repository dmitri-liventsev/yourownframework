<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>KittyBook The first social network for cats</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/jumbotron.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">KittyBook</a>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <?php if (!$this->auth->isLoggedIn()): ?>
                <form class="navbar-form navbar-right" action="/auth/login" method="post">
                    <div class="form-group">
                        <input type="text" name="email" placeholder="Email" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" class="form-control">
                    </div>
                    <input type="hidden" name="csrf" value="<?php echo $token; ?>">
                    <button type="submit" class="btn btn-success">Sign in</button>
                </form>
            <?php else: ?>
                <a href="/auth/logout">
                    <button type="button" class="btn btn-danger pull-right top6">Logout</button>
                </a>
                <a href="/profile/edit">
                <button type="button" class="btn btn-primary pull-right top6">Edit Profile</button>
                </a>

            <?php endif; ?>
        </div><!--/.navbar-collapse -->

    </div>
</nav>

<div class="container">
    <!-- Example row of columns -->
    <div class="row">
        <?php echo $content; ?>
    </div>

    <hr>

    <footer>
        <p>&copy; 2017 Dmitri Liventsev, Inc.</p>
    </footer>
</div> <!-- /container -->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="/js/bootstrap.min.js"></script>
<script src="/js/profileversion.jquery.js"></script>
</body>
</html>