<?php echo AUTOGENERATED_CONFIGS; ?>

<?php /** @var Template_VariableAccessor $VAR */ ?>
<?php
if (!$VAR->domain->webmailActive) {
    echo "# Domain is disabled or suspended\n";
    return;
}
?>
ServerAlias "webmail.<?php echo $VAR->domain->asciiName ?>"
<?php foreach ($VAR->domain->mailAliases AS $alias): ?>
    ServerAlias  "webmail.<?php echo $alias->asciiName ?>"
<?php endforeach; ?>
