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
            <?php echo $this->Html->link($episode->id,'/blogjf/episode/view/'.$episode->id) ?>
        </td>
        <td>
            <?php echo $episode->title?>
        </td>
        <td>
            <?php echo $this->dateFormat($episode->created);?>
        </td>
        <td>
            <?php echo $this->dateFormat($episode->modified);?>
        </td>
        <td>
            <?php echo $this->Html->link('<span class="glyphicon glyphicon-edit"></span>' ,'/blogjf/episode/edit/'.$episode->id) ?>
            <?php echo $this->Html->link('<span class="glyphicon glyphicon-trash"></span>' ,'/blogjf/episode/delete/'.$episode->id) ?>
        </td>
    </tr>
    <?php } ?>
</table>
<script type="text/javascript">
$('.active').removeClass('active');
$('#episode').addClass('active');
</script>
