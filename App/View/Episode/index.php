<table class="table">
    <tr>
        <th>ID</td>
            <th>Titre</td>
                <th>Création</td>
                    <th>Modification</td>
                        <th>Action</td>
    </tr>
    <?php foreach($episodes as $episode){?>
    <tr>
        <td>
            <?= $this->Html()->link($episode->id,'/Episode/view/'.$episode->id) ?>
        </td>
        <td>
            <?= $episode->title?>
        </td>
        <td>
            <?= $this->dateFormat($episode->created);?>
        </td>
        <td>
            <?= $this->dateFormat($episode->modified);?>
        </td>
        <td>
            <?= $this->Html()->link('<span class="glyphicon glyphicon-edit"></span>' ,'/Episode/edit/'.$episode->id) ?>
            <?= $this->Html()->link('<span class="glyphicon glyphicon-trash"></span>' ,'/Episode/delete/'.$episode->id) ?>
        </td>
    </tr>
    <?php } ?>
</table>
<script type="text/javascript">
$('.active').removeClass('active');
$('#episode').addClass('active');
</script>
