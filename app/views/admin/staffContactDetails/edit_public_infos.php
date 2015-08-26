<div class="row">
    <h1>Vos infos officielles en tant que membre du staff</h1>
    <div class="col-lg-offset-4 col-lg-4 col-md-12">
        <form  method="post" action="<?= WEBROOT . 'admin/staffContactDetails/' . Session::get()->id; ?>" enctype="multipart/form-data">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
                <label for="shown_name">Nom officiel</label>
                <input name="shown_name" type="text" class="form-control" id="shown_name" placeholder="Nom officiel" value="<?= isset($infos->shown_name) ? $infos->shown_name : ''; ?>">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description" rows="5" placeholder="Decrivez-vous..."><?= isset($infos->description) ? $infos->description : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label for="team_img_name">Avatar officiel</label>
                <input type="file" name="team_img_name" id="team_img_name">
            </div>
            <br>
            <button class="btn btn-primary" name="type" value="public" type="submit">Envoyer</button>
        </form>
    </div>
</div>