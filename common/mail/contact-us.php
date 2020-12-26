<?= $this->render('_mailheader') ?>

You have a new enquiry

<table>
    <thead>
        Enquiry Details
    </thead>
    <tbody>

        <tr>
            <td>Name: </td>
            <td><?php echo $name; ?></td>
        </tr>
        <tr>
            <td>Email: </td>
            <td><?php echo $email; ?></td>
        </tr>
        <tr>
            <td>Phone: </td>
            <td><?php echo $phone; ?></td>
        </tr>
        <tr>
            <td>Message: </td>
            <td><?php echo $message; ?></td>
        </tr>
    </tbody>
</table>

<?= $this->render('_mailfooter') ?>