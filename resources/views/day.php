<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <td style="text-align: center;">
        <a class="btn btn-primary" href="?controller=tinhtoan&Id=<?= $category['IDgiaovien'] ?>&NH=<?= $category['namhoc'] ?>">CT
        </a>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" style="min-width: 1000px">
                <div class="modal-content">
                    <h3 class="modal-title"><strong>Chi tiết</strong></h3>
                    <div class="modal-title text-left pl-4">
                        <?php
                        if (!empty($ctgv)) { ?><?php

                                                foreach ($ctgv as $category2) { ?>
                        <label for="" class="title-ct text-secondary font-weight-normal">Tên giáo viên:</label>
                        <label for="exampleInputEmail1" style="text-align:left;"><?= $category2['Tengiaovien'] ?></label>
                        <br />
                        <label for="exampleInputEmail1" style="text-align:left;" class="title-ct text-secondary font-weight-normal">Chức danh:</label>
                        <label for="exampleInputEmail1" style="text-align:left;"><?= $category2['Chucdanh'] ?></label>
                        <br />
                        <label class="title-ct text-secondary font-weight-normal" for="exampleInputEmail1" style="text-align:left;">Chức vụ :</label>
                        <label for="exampleInputEmail1" style="text-align:left;"><?= $category2['Tenchucvu'] ?></label>
                    <?php } ?>
                <?php } else {
                        }
                ?>
                    </div>
                    <div class="modal-header">
                        <br />
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">ID</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Tên giáo viên</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">lớp</th>
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Môn học</th>
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Năm học</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Học kỳ</th>
                                    <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Tổng tiết</th>



                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                if (!empty($ct)) { ?><?php

                                                        foreach ($ct as $category) { ?>
                                <tr role="row" class="odd">

                                    <td><?= $category['IDqlklgdgiaovien'] ?></td>
                                    <td><?= $category['Tengiaovien'] ?></td>
                                    <td><?= $category['Tenlop'] ?></td>
                                    <td><?= $category['TenMH'] ?></td>
                                    <td><?= $category['namhoc'] ?></td>
                                    <td><?= $category['hocky'] ?></td>
                                    <td><?= $category['Tongtiet'] ?></td>
                                </tr>
                            <?php } ?>
                        <?php } else {
                                }
                        ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </td>
</body>

</html>
<script>
    $(document).ready(function() {
        function GetParameterValues(param) {
            var url = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < url.length; i++) {
                var urlparam = url[i].split('=');
                if (urlparam[0] == param) {
                    return urlparam[1];
                }
            }
        }
        if (GetParameterValues('Id')) {
            $('#viewModal').click();
        }
    });
</script>