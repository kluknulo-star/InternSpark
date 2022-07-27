
<table class="table table-striped table-hover mt-2">
    <thead class="thead-dark">
    <tr>
        <th scope="col">Course id</th>
        <th scope="col">Title course</th>
        <th scope="col">Author Name</th>
        <th scope="col">Content</th>
        <th scope="col">deleted_at</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php


    $page = $_GET['views'] ?? 1;
    $per_page = 10;


    $total = $CourseData->getCountCourseRecords($userId, "user");

    $pagination = new Pagination((int)$page, $per_page, $total);
    $start = $pagination->get_start();

    $sliceCourseData = $CourseData->sliceRead($userId,$start, $per_page, "user");

    foreach ($sliceCourseData as $row) {
        ?>
        <tr>

            <?php echo $row;
            //                var_dump($row);
            ?>

            <td>
                <a href="courses/<?php echo $row->getIdCourse()?>/view" class="btn btn-light btn-sm"
                   data-toggle="modal"><i class="fa fa-eye"></i></a>


            </td>
        </tr>


    <?php } ?>
    </tbody>
</table>




<div class="d-flex justify-content-center">
    <?php echo $pagination; ?>
</div>