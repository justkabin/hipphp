<?php
{*@package HipPhp*}
{*@author  Shane Barron <admin@hipphp.com>*}
$views = Viewlocation::readFile();
?>
<h2>Views</h2>
<table class="table">
    <thead>
        <tr>
            <th scope="col">View Name</th>
            <th scope="col">View Location</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($views as $key => $value) { ?>
        <tr>
            <td><?php echo $key; ?></td>
            <td><?php echo $value; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>


