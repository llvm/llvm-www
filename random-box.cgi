#!/usr/bin/perl -w

print "Content-type: text/html\n\n";

sub ReadFile {
  undef $/;
  if (open (FILE, $_[0])) {
    my $Ret = <FILE>;
    close FILE;
    return $Ret;
  } else {
    print "Could not open file '$_[0]' for reading!";
    return "";
  }
}


opendir DH, "RandomBoxes" or die "Where'd RandomBoxes go?";
@Files = grep /[0-9]/, readdir DH;
closedir DH;

srand(time ^ $$);
print ReadFile "RandomBoxes/" . $Files[rand(@Files)];
print "\n";
exit(0);
