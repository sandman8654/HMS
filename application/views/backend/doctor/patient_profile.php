<?php
$patient_info = $this->crud_model->select_patient_info_by_patient_id($param2);
foreach ($patient_info as $row) { ?>

    <div class="profile-env">

        <header class="row">

            <div class="col-sm-3">

                <a href="#" class="profile-picture">
                    <img src="<?php echo $this->crud_model->get_image_url('patient', $row['patient_id']); ?>" 
                         class="img-responsive img-circle" />
                </a>

            </div>

            <div class="col-sm-9">

                <ul class="profile-info-sections">
                    <li style="padding:0px; margin:0px;">
                        <div class="profile-name">
                            <h3><?php echo $row['name']; ?></h3>
                        </div>
                    </li>
                </ul>

            </div>


        </header>

        <section class="profile-info-tabs">

            <div class="row">

                <div class="">
                    <br>
                    <table class="table table-bordered">

                        <?php if ($row['email'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('email'); ?></td>
                                <td><b><?php echo $row['email']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['address'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('address');?></td>
                                <td><b><?php echo $row['address']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['phone'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('phone');?></td>
                                <td><b><?php echo $row['phone']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['sex'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('sex');?></td>
                                <td><b><?php echo $row['sex']; ?></b></td>
                            </tr>
                        <?php endif; ?>


                        <?php if ($row['birth_date'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('birth_date');?></td>
                                <td><b><?php echo date('d/m/Y', $row['birth_date']); ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['age'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('age');?></td>
                                <td><b><?php echo $row['age']; ?></b></td>
                            </tr>
                        <?php endif; ?>

                        <?php if ($row['blood_group'] != ''): ?>
                            <tr>
                                <td><?php echo get_phrase('blood_group');?></td>
                                <td><b><?php echo $row['blood_group']; ?></b>
                                </td>
                            </tr>
                        <?php endif; ?>

                    </table>
                </div>
            </div>
            
        </section>

    </div>

<?php } ?>