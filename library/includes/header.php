<div class="navbar navbar-inverse set-radius-zero" >
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" >
                <img src="assets/img/logo.png" />
            </a>
        </div>

        <!-- ✅ Search bar start -->
        <div style="margin-top: 15px; display: flex; justify-content: center;">
            <form method="GET" action="search.php" style="display: flex;">
                <input type="text" name="query" placeholder="Search books by title or author" required
                    style="padding: 5px; width: 300px;" />
                <button type="submit" style="padding: 5px 10px;">Search</button>
            </form>
        </div>
        <!-- ✅ Search bar end -->

        <?php if($_SESSION['login']) { ?> 
        <div class="right-div">
            <a href="logout.php" class="btn btn-danger pull-right">LOG ME OUT</a>
        </div>
        <?php } ?>
    </div>
</div>
