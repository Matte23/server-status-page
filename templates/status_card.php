<div class="card <?php echo $color ?> text-white mb-3">
    <div class="card-body">
        <?php if(isset($test->tests)) {
            $id = str_replace(" ","_",$test->name);
            echo "<button style=\"font-size:1.7rem;
                                  margin-top: -1.075rem;
                                  margin-right: 0rem;
                                  margin-bottom: -1.075rem;
                                  margin-left: -0.75rem;
                                  padding-top: 0rem;
                                  padding-right: 0.75rem;
                                  padding-bottom: -0rem;
                                  padding-left: 0.75rem;\"
                          class=\"btn text-white\" data-toggle=\"collapse\" data-target=\"#$id\">+</button>";
        } ?>
        <span><?php echo $test->name ?></span>
        <span style="float: right"><?php echo $status ?></span>
    </div>
    <?php echo $nested_group ?>
</div>
