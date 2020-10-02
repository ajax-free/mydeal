<section class="content__side">
  <h2 class="content__side-heading">Проекты</h2>

  <nav class="main-navigation">
      <ul class="main-navigation__list">
          <?php
              foreach ($arr_projects as $key => $value) {
                  //проверяем гет параметр
                  if($project_show==$key){
                      $active_project = 'main-navigation__list-item--active';
                  }

                  echo '
                  <li class="main-navigation__list-item '.$active_project.'">
                      <a class="main-navigation__list-item-link" href="/?show='.$key.'">'.$value.'</a>
                      <span class="main-navigation__list-item-count">'.count_tasks($author = 1, $key).'</span>
                  </li>
                  ';
                  $active_project = '';    
              }
          ?>
      </ul>
  </nav>

  <a class="button button--transparent button--plus content__side-button" href="form-project.html">Добавить проект</a>
</section>

<main class="content__main">
  <h2 class="content__main-heading">Добавление задачи</h2>

  <form class="form"  action="/add.php" method="post" autocomplete="off" enctype="multipart/form-data">
    <div class="form__row">
      <label class="form__label" for="name">Название <sup>*</sup>
              <?php
                echo "<p class='form__message'>".$err_form['name']."</p>";
              ?>
      </label>

      <input class="form__input <?php echo $err_form['name'] ? 'form__input--error' : '' ?>" type="text" name="name" id="name" value="<?php echo $val_form['name'] ? $val_form['name'] : '' ?>" placeholder="Введите название">
    </div>

    <div class="form__row">
      <label class="form__label" for="project">Проект <sup>*</sup>
              <?php
                echo "<p class='form__message'>".$err_form['project']."</p>";
              ?>
      </label>

      <select class="form__input form__input--select <?php echo  $err_form['project']? 'form__input--error' : '' ?>" name="project" id="project">
        <?php
          echo '<option value="">Выберите проект</option>';
          foreach ($arr_projects as $key => $value) {
            if($val_form['project'] && $val_form['project'] == $key){
              echo '<option value="'.$key.'" selected>'.$value.'</option>';
            } else {
              echo '<option value="'.$key.'">'.$value.'</option>';
            }
          }
        ?>
      </select>
    </div>

    <div class="form__row">
      <label class="form__label" for="date">Дата выполнения
              <?php
                echo "<p class='form__message'>".$err_form['date']."</p>";
              ?>
      </label>

      <input class="form__input form__input--date <?php echo  $err_form['date']? 'form__input--error' : '' ?>" type="text" name="date" id="date" value="<?php echo $val_form['date'] ? $val_form['date'] : '' ?>" placeholder="Введите дату в формате ГГГГ-ММ-ДД">
    </div>

    <div class="form__row">
      <label class="form__label" for="file">Файл
              <?php
                echo "<p class='form__message'>".$err_form['file']."</p>";
              ?>
      </label>

      <div class="form__input-file">
        <input class="visually-hidden" type="file" name="file" id="file" value="">

        <label class="button button--transparent" for="file">
          <span>Выберите файл</span>
        </label>
      </div>
    </div>

    <?php
      echo "<p class='form__message'>".$err_form['text']."</p>";
      echo "<p class='form__message'>".$val_form['status']."</p>";
    ?>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="addtask" value="Добавить">
    </div>
  </form>
</main>