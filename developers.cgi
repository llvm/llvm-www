#!/usr/bin/perl -w


#
# CopyInclude - Copy the contents of an include file to page.
#
sub CopyInclude {
  (my $file_name) = @_;

  if (open(INCLUDE, "<".$file_name)) {
    while ($include = <INCLUDE>) {
      print $include;
    }
    close INCLUDE;
  } else {
    print "Could not open file '$file_name' for reading!\n";
    exit;
  }
}

#
# Prolog - Issue all text prior to table.
#
sub Prolog {
  # Issue the include prolog
  CopyInclude("header.incl");
  
  # Issue the table prolog
  print <<EOD
<div class="www_sectiontitle">Meet The LLVM Developers</div>

<p>The developers of LLVM have a variety of backgrounds and interests. This page
provides links to each developer's home page (or LLVM page if they have one).
If you'd like to get a link added to this page, email or contact us!</p>

<center>
<table cellpadding=2 cellspacing=3 border=0>
  <tr align=center>
    <td><b>Name</b></td>
    <td><b>Picture</b></td>
    <td>&nbsp;</td>
    <td><b>Name</b></td>
    <td><b>Picture</b></td>
  </tr>
EOD
;
}

#
# Epilog - Issue all text after table.
#
sub Epilog {
  # Issue the table epilog
  print <<EOD
</table>
</center>
EOD
;

  # Issue the include epilog
  CopyInclude("footer.incl");
}

# Start the html page
print "Content-type: text/html\n\n";

# Issue the page prolog
Prolog;

# Open the developer data file
if (!open(DEVELOPERS, "<"."developers.txt")) {
   print "Could not open file 'developers.txt' for reading!\n";
   exit;
}

# Iterate though all developer data
my %Developers = ();
my @Fullnames = ();
my %Person = ();

while (my $Line = <DEVELOPERS>) {
  # Clean up line
  chomp $Line;
  # Skip blank lines
  next if $Line =~ /^\s*$/;
  
  # Split out firstname surname and parameters
  if ($Line =~ /\s*(\w+)\s+(\w+)\s+(.*)$/) {
    my ($Name, $Surname,$Rest) = ($1, $2, $3);
    # Create sorting name
    my $Fullname = $Surname.", ".$Name;
    # Construct developer record
    my %Developer = ( name => $Name, surname => $Surname );
    # Break down parameters
    my @Params = split(/\s+/, $Rest);
    
    # For each parameter
    for my $Param (@Params) {
      # Break out key and value
      if ($Param =~ /^\s*(\w+)\s*=\s*(\S*)\s*/) {
        my ($Key, $Value) = ($1, $2);
        # Add parameter to developer record
        $Developer{$Key} = $Value;
      } else {
        # Error
        print "Unrecognized developer parameter: $Param\n";
        exit;
      }
    }
    
    # Add developer to database
    $Developers{$Fullname} = {%Developer};
    # Add sort name to sort array
    push @Fullnames, $Fullname;
  } else {
    # Error
    print "Unrecognized developer record\n";
    print $Line."\n";
    exit;
  }
}

# Close the developer data file
close DEVELOPERS;

# Sort names
@Fullnames = sort @Fullnames;

# Track column
my $Column = 0;

# For each developer in sorted order
for my $Fullname (@Fullnames) {
  # Extract fields
  my $Person = $Developers{$Fullname};
  my $Name = $Person->{name};
  my $Surname = $Person->{surname};
  my $HRef = $Person->{href};
  my $Image = $Person->{img};
  my $Width = $Person->{width};
  my $Height = $Person->{height};
  my $Alt = $Person->{alt};
  
  print "  <tr align=center>\n" if $Column == 0;
  print "    <td>\n";
  print "      <a href=\"$HRef\">\n" if (defined $HRef);
  print "         $Name $Surname\n";
  print "      </a>\n" if (defined $HRef);
  print "    </td>\n";
  
  print "    <td>\n";
  print "      <a href=\"$HRef\">\n" if (defined $HRef);
  print "        <img src=\"img/$Image\"";
                      print " width=\"$Width\"" if defined $Width;
                      print " height=\"$Height\"" if defined $Height;
                      print " alt=\"$Alt\"" if defined $Alt;
                      print " title=\"$Alt\"" if defined $Alt;
                      print ">\n";
  print "      </a>\n" if (defined $HRef);
  print "    </td>\n";
  
  print "  </tr>\n" if $Column == 1;
  print "  <td>&nbsp;</td>  " if $Column == 0;
  $Column = $Column ^ 1;
}

# Clean up if odd number of developers
if ($Column == 1) {
  print "    <td>\n";
  print "    </td>\n";
  print "  </tr>\n";
}

# Issue the table epilog
Epilog;

exit;
