<!doctype html>
<html>
    <head>
        <title>harviacode.com - codeigniter crud generator</title>
        <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css') ?>"/>
        <style>
            body{
                padding: 15px;
            }
        </style>
    </head>
    <body>
        <h2 style="margin-top:0px">City_area Read</h2>
        <table class="table">
	    <tr><td>City Id</td><td><?php echo $city_id; ?></td></tr>
	    <tr><td>Name</td><td><?php echo $name; ?></td></tr>
	    <tr><td></td><td><a href="<?php echo site_url('city_area') ?>" class="btn btn-default">Cancel</a></td></tr>
	</table>
        </body>
</html>