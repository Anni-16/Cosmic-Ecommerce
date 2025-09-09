<?php require_once('header.php'); ?>

<?php
if (isset($_POST['form1'])) {
    $valid = 1;
    $error_message = '';

    // Validate name
    if (empty($_POST['testimonial_name'])) {
        $valid = 0;
        $error_message .= "Name cannot be empty<br>";
    }

    if ($valid == 1) {
        // Insert into DB
        $statement = $pdo->prepare("INSERT INTO tbl_testimonial (
            testimonial_name,
            testimonial_content,
            status
        ) VALUES (?, ?, ?)");

        $statement->execute([
            $_POST['testimonial_name'],
            $_POST['testimonial_content'],
            $_POST['status']
        ]);

        $success_message = 'Testimonial has been added successfully.';
    }
}
?>

<section class="content-header">
    <div class="content-header-left">
        <h1>Add Testimonial</h1>
    </div>
    <div class="content-header-right">
        <a href="testimonial.php" class="btn btn-primary btn-sm">View All</a>
    </div>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">

            <?php if (!empty($error_message)): ?>
                <div class="callout callout-danger">
                    <p><?php echo $error_message; ?></p>
                </div>
            <?php endif; ?>

            <?php if (!empty($success_message)): ?>
                <div class="callout callout-success">
                    <p><?php echo $success_message; ?></p>
                </div>
            <?php endif; ?>

            <form class="form-horizontal" action="" method="post">
                <div class="box box-info">
                    <div class="box-body">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name <span>*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="testimonial_name" class="form-control" placeholder="Enter Name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-8">
                                <textarea name="testimonial_content" class="form-control" cols="30" rows="10" placeholder="Enter Description" id="wordLimitBox" oninput="limitWords(this, 50)"></textarea>
                                <small><span id="wordCount">0</span>/50 words</small>
                            </div>
                        </div>

                        <script>
                            function limitWords(textarea, maxWords) {
                                const words = textarea.value.trim().split(/\s+/);
                                if (words.length > maxWords) {
                                    textarea.value = words.slice(0, maxWords).join(" ");
                                }
                                document.getElementById("wordCount").innerText = words.slice(0, maxWords).length;
                            }
                        </script>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Show on Menu? <span>*</span></label>
                            <div class="col-sm-4">
                                <select name="status" class="form-control" style="width:auto;" required>
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-success" name="form1">Add Testimonial</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>

        </div>
    </div>
</section>

<?php require_once('footer.php'); ?>
