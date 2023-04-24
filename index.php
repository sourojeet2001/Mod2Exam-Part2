<?php
include("NameDetails.php");
$obj = new NameDetails();
$q2 = $obj->showData("Uploads");
$q2->setFetchMode(PDO::FETCH_ASSOC);
?>
<form method="post" action="submitTeam.php">
    <?php while ($row2 = $q2->fetch()): ?>
        <div class="inner">
            <div>
                <h1>
                    <?php echo htmlspecialchars($row2['EmpName']) ?>
                </h1>
                <h1>
                    <?php echo htmlspecialchars($row2['EmpId']) ?>
                </h1>
                <div class="flex">
                    <h3>
                        <?php echo htmlspecialchars($row2['EmpType']) ?>
                    </h3>
                    <h3>
                        <?php echo htmlspecialchars($row2['EmpPoint']) ?>4
                    </h3>
                    <input type="checkbox" name="players[]" value="<?php echo ($row2['EmpId']) ?>" data-points="<?php echo ($row2['EmpPoint']) ?>">
                </div>
            </div>
        </div>
    <?php endwhile; ?>
    <div class="submit">
        <button type="button" name="submit" id="submitBtn" disabled>Submit Team</button>
    </div>
</form>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>