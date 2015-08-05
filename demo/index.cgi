#!/usr/bin/perl -w
# LLVM Web Demo script
#

use strict;
use CGI;
use POSIX;
use Mail::Send;

$| = 1;

my $ROOT = "/tmp/webcompile";

open( STDERR, ">&STDOUT" ) or die "can't redirect stderr to stdout";

if ( !-d $ROOT ) { mkdir( $ROOT, 0777 ); }

my $LOGFILE         = "$ROOT/log.txt";
my $FORM_URL        = 'index.cgi';
my $MAILADDR        = 'sabre@nondot.org';
my $CONTACT_ADDRESS = 'Questions or comments?  Email the <a href="http://lists.llvm.org/mailman/listinfo/llvm-dev">LLVM-dev mailing list</a>.';
my $LOGO_IMAGE_URL  = '../img/DragonSmall.png';
my $TIMEOUTAMOUNT   = 20;

my @PREPENDPATHDIRS =
    ('/opt/clang-releases/llvm/bin');

my $defaultsrc = "#include <stdio.h>\n#include <stdlib.h>\n\n" .
                 "int factorial(int X) {\n  if (X == 0) return 1;\n" .
                 "  return X*factorial(X-1);\n}\n\n" .
                 "int main(int argc, char **argv) {\n" .
                 "  printf(\"%d\\n\", factorial(atoi(argv[1])));\n}\n";

sub getname {
    my ($extension) = @_;
    for ( my $count = 0 ; ; $count++ ) {
        my $name =
          sprintf( "$ROOT/_%d_%d%s", $$, $count, $extension );
        if ( !-f $name ) { return $name; }
    }
}

my $c;

sub barf {
    print "<b>", @_, "</b>\n";
    print $c->end_html;
    system("rm -f $ROOT/locked");
    exit 1;
}

sub writeIntoFile {
    my $extension = shift @_;
    my $contents  = join "", @_;
    my $name      = getname($extension);
    local (*FILE);
    open( FILE, ">$name" ) or barf("Can't write to $name: $!");
    print FILE $contents;
    close FILE;
    return $name;
}

sub addlog {
    my ( $source, $pid, $result ) = @_;
    open( LOG, ">>$LOGFILE" );
    my $time       = scalar localtime;
    my $remotehost = $ENV{'REMOTE_ADDR'};
    print LOG "[$time] [$remotehost]: $pid\n";
    print LOG "<<<\n$source\n>>>\nResult is: <<<\n$result\n>>>\n";
    close LOG;
}

sub syntaxHighlightConsoleOutput {
  my ($input) = @_;
  $input =~ s@\033\[(?:\d;)?(\d);?((?:\d\d)?)m@</span><span class="terminalStyle$1$2">@g;
  return $input;
}

sub dumpFile {
    my ( $header, $file ) = @_;
    my $result;
    open( FILE, "$file" ) or barf("Can't read $file: $!");
    while (<FILE>) {
        $result .= $_;
    }
    close FILE;
    my $UnhilightedResult = $result;
    my $HtmlResult        =
      "<h3>$header</h3>\n<pre>\n<span>" . syntaxHighlightConsoleOutput($c->escapeHTML($result)) . "</span>\n</pre>\n";
    if (wantarray) {
        return ( $UnhilightedResult, $HtmlResult );
    }
    else {
        return $HtmlResult;
    }
}

sub syntaxHighlightLLVM {
  my ($input) = @_;
  $input =~ s@\b(void|i\d+|float|double|x86_fp80|fp128|ppc_fp128|type|label|opaque)\b@<span class="llvm_type">$1</span>@g;
  $input =~ s@\b(ret|br|switch|indirectbr|invoke|unwind|unreachable|add|sub|mul|udiv|sdiv|fdiv|urem|srem|frem|shl|lshr|ashr|and|or|xor|extractelement|insertelement|shufflevector|extractvalue|insertvalue|malloc|free|alloca|load|store|getelementptr|trunc|zext|sext|fptrunc|fpext|fptoui|fptosi|uitofp|sitofp|ptrtoint|inttoptr|bitcast|to|blockaddress|icmp|fcmp|phi|select|call|va_arg|eq|ne|ugt|uge|ult|ule|sgt|sge|slt|sle|oeq|ogt|oge|olt|ole|one|ord|ueq|une|uno|tail|begin|end|true|false|declare|global|constant|const|private|internal|linkonce|common|weak|appending|extern_weak|dllimport|dllexport|ccc|fastcc|coldcc|uninitialized|external|implementation|linkonce|weak|appending|null|except|not|target|endian|pointersize|big|little|volatile|zeroinitializer|define|protected|hidden|addrspace|section|align|alias|signext|zeroext|inreg|byval|sret|noalias|nocapture|nest|gc|alwaysinline|noinline|optsize|noreturn|nounwind|readnone|readonly|ssp|sspreq|module|asm|sideeffect)\b@<span class="llvm_keyword">$1</span>@g;

  # Add links to the FAQ.
  $input =~ s@(_ZNSt8ios_base4Init[DC]1Ev)@<a href="../docs/FAQ.html#iosinit">$1</a>@g;
  $input =~ s@\bundef\b@<a href="../docs/FAQ.html#undef">undef</a>@g;
  return $input;
}

sub mailto {
    my ( $recipient, $body ) = @_;
    my $msg =
      new Mail::Send( Subject => "LLVM/Clang Demo Page Run", To => $recipient );
    my $fh = $msg->open();
    print $fh $body;
    $fh->close();
}

$c = new CGI;
print $c->header;

print <<EOF;
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <title>Try out LLVM and Clang in your browser!</title>
  <style>
    \@import url("syntax.css");
    \@import url("http://llvm.org/llvm.css");
  </style>
</head>
<body leftmargin="10" marginwidth="10">

<div class="www_sectiontitle">
  Try out LLVM and Clang 3.0 in your browser!
</div>
The LLVM demo page is currently disabled.
<table border=0><tr><td>
<img align=right width=100 height=111 src="$LOGO_IMAGE_URL">
</td><td>
EOF
exit 0;

if ( -f "$ROOT/locked" ) {
  my ($dev,$ino,$mode,$nlink,$uid,$gid,$rdev,$size,$atime,$locktime) = 
    stat("$ROOT/locked");
  my $currtime = time();
  if ($locktime + 60 > $currtime) {
    print "This page is already in use by someone else at this ";
    print "time, try reloading in a second or two.</td></tr></table>'\n";
    exit 0;
  }
}

system("touch $ROOT/locked");

print <<END;
Paste a C/C++ program in the text box or
upload one from your computer, and you can see LLVM and Clang compile it!!
Rawr!!!
</td></tr></table><p>
END

my %llvmTargets = ();
$llvmTargets{'x86'} = { label => '32-bit X86: Pentium-Pro and above'  };
$llvmTargets{'x86-64'}  = { label => '64-bit X86: EM64T and AMD64' };
$llvmTargets{'llvm'} = { label => 'LLVM assembly' };
$llvmTargets{'cpp'}  = { label => 'LLVM C++ API code' };
my %targetLabels = map { $_ => $llvmTargets{$_}->{'label'} } keys %llvmTargets;
sub llvmTargetsSortedByLabel {
  $llvmTargets{$a}->{'label'} cmp $llvmTargets{$b}->{'label'};
}

my @sortedTargets = sort llvmTargetsSortedByLabel keys %llvmTargets;

print $c->start_multipart_form( 'POST', $FORM_URL );

my $source = $c->param('source');


# Start the user out with something valid if no code.
$source = $defaultsrc if (!defined($source));

print '<table border="0"><tr><td>';

print "Type your source code in below: (<a href='DemoInfo.html#hints'>hints and 
advice</a>)<br>\n";

print $c->textarea(
    -name    => "source",
    -rows    => 16,
    -columns => 60,
    -default => $source
), "<br>";

print "Or upload a file: ";
print $c->filefield( -name => 'uploaded_file', -default => '' );

print "<p />\n";


print '<p></td><td valign=top>';

print "<center><h3>General Options</h3></center>";

print "Source language: ",
  $c->radio_group(
    -name    => 'language',
    -values  => [ 'C', 'C++' ],
    -default => 'C'
  ), "<p>";

print "Optimization level: ",
  $c->radio_group(
    -name    => 'optlevel',
    -values  => [ 'LTO', 'Standard', 'None' ],
    -default => 'Standard'
  ),' <a href="DemoInfo.html#optlevel">?</a><br>', "<p>";

print $c->checkbox(
    -name  => 'showstats',
    -label => 'Show detailed pass statistics'
  ), ' <a href="DemoInfo.html#stats">?</a><br>';

print $c->checkbox(
    -name  => 'cxxdemangle',
    -label => 'Demangle C++ names'
  ),' <a href="DemoInfo.html#demangle">?</a><p>';


print "<center><h3>Output Options</h3></center>";

print "Target: ",
  $c->popup_menu(
    -name    => 'target',
    -default => 'llvm',
    -values => \@sortedTargets,
    -labels => \%targetLabels
  ), ' <a href="DemoInfo.html#target">?</a><p>';

print $c->checkbox(
    -name => 'showbcanalysis',
    -label => 'Show detailed bytecode analysis'
  ),' <a href="DemoInfo.html#bcanalyzer">?</a><br>';

print "</td></tr></table>";

print "<center>", $c->submit(-value=> 'Compile Source Code'), 
      "</center>\n", $c->endform;

print "\n<p>If you have questions about the LLVM code generated by the
front-end, please check the <a href='/docs/FAQ.html#cfe_code'>FAQ</a> and
the demo page <a href='DemoInfo.html#hints'>hints section</a>.
</p>\n";

$ENV{'PATH'} = ( join ( ':', @PREPENDPATHDIRS ) ) . ":" . $ENV{'PATH'};

sub sanitychecktools {
    my $sanitycheckfail = '';

    # insert tool-specific sanity checks here
    $sanitycheckfail .= ' llvm-dis'
      if `llvm-dis --help 2>&1` !~ /ll disassembler/;

    $sanitycheckfail .= ' clang'
      if `clang --help 2>&1` !~ /clang "gcc-compatible" driver/;

    $sanitycheckfail .= ' llvm-ld'
      if `llvm-ld --help 2>&1` !~ /llvm linker/;

    $sanitycheckfail .= ' llc'
      if `llc --help 2>&1` !~ /llvm system compiler/;

    $sanitycheckfail .= ' llvm-bcanalyzer'
      if `llvm-bcanalyzer --help 2>&1` !~ /bcanalyzer/;
    $sanitycheckfail .= ' clang'
      if `clang --version 2>&1` !~ /clang/;

    barf(
"<br/>The demo page is currently unavailable. [tools: ($sanitycheckfail ) failed sanity check]"
      )
      if $sanitycheckfail;
}

sanitychecktools();

sub try_run {
    my ( $program, $commandline, $outputFile ) = @_;
    my $retcode = 0;

    eval {
        local $SIG{ALRM} = sub { die "timeout"; };
        alarm $TIMEOUTAMOUNT;
        $retcode = system($commandline);
        alarm 0;
    };
    if ( $@ and $@ =~ /timeout/ ) { 
      barf("Program $program took too long, compile time limited for the web script, sorry!.\n"); 
    }
    if ( -s $outputFile ) {
        print scalar dumpFile( "Output from $program", $outputFile );
    }
    #print "<p>Finished dumping command output.</p>\n";
    if ( WIFEXITED($retcode) && WEXITSTATUS($retcode) != 0 ) {
        barf(
"$program exited with an error. Please correct source and resubmit.<p>\n" .
"Please note that this form only allows fully formed and correct source" .
" files.  It will not compile fragments of code.<p>"
        );
    }
    if ( WIFSIGNALED($retcode) != 0 ) {
        my $sig = WTERMSIG($retcode);
        barf(
            "Ouch, $program caught signal $sig. Sorry, better luck next time!\n"
        );
    }
}

my %suffixes = (
    'C'                => '.c',
    'C++'              => '.cc',
    'Objective-C'      => '.m',
    'Objective-C++'    => '.mm',
    'preprocessed C'   => '.i',
    'preprocessed C++' => '.ii'
);
my %languages = (
    '.c'    => 'C',
    '.i'    => 'preprocessed C',
    '.ii'   => 'preprocessed C++',
    '.cc'   => 'C++',
    '.cpp'  => 'C++',
);
my %language_options = (
    'C'                => '',
    'C++'              => '',
    'preprocessed C'   => '',
    'preprocessed C++' => ''
);

my $uploaded_file_name = $c->param('uploaded_file');
if ($uploaded_file_name) {
    if ($source) {
        barf(
"You must choose between uploading a file and typing code in. You can't do both at the same time."
        );
    }
    $uploaded_file_name =~ s/^.*(\.[A-Za-z0-9]+)$/$1/;
    my $language = $languages{$uploaded_file_name};
    $c->param( 'language', $language );

    print "<p>Processing uploaded file. It looks like $language.</p>\n";
    my $fh = $c->upload('uploaded_file');
    if ( !$fh ) {
        barf( "Error uploading file: " . $c->cgi_error );
    }
    while (<$fh>) {
        $source .= $_;
    }
    close $fh;
}

if ($c->param && $source) {
    # Since we inject target name in command line tool (llc), we need to
    # validate it properly. Check if chosen target is an known valid target.
    my $target = $c->param('target');
    my $targetHTML = $c->escapeHTML($target);
    barf(
      "Unknown target $targetHTML. Please choose another one."
    ) unless exists $llvmTargets{$target};

    print $c->hr;
    my $extension = $suffixes{ $c->param('language') };
    barf "Unknown language; can't compile\n" unless $extension;

    # Add a newline to the source here to avoid a warning from gcc.
    $source .= "\n";

    # Avoid security hole due to #including bad stuff.
    $source =~
s@(\n)?#include.*[<"](.*\.\..*)[">].*\n@$1#error "invalid #include file $2 detected"\n@g;

    my $inputFile = writeIntoFile( $extension, $source );
    my $pid       = $$;

    my $bytecodeFile = getname(".bc");
    my $outputFile   = getname(".clang.out");
    my $timerFile    = getname(".clang.time");

    my $stats = '';
    #$stats = "-Wa,--stats,--time-passes,--info-output-file=$timerFile"
    $stats = "-ftime-report"
	if ( $c->param('showstats') );

    my $options = $language_options{ $c->param('language') };
    $options .= " -O3" if $c->param('optlevel') ne "None";

    try_run( "llvm C/C++ front-end (clang)",
	"clang -fcolor-diagnostics -emit-llvm -msse3 -W -Wall $options $stats -o $bytecodeFile -c $inputFile > $outputFile 2>&1",
      $outputFile );

    if ( $c->param('showstats') && -s $timerFile ) {
        my ( $UnhilightedResult, $HtmlResult ) =
          dumpFile( "Statistics for front-end compilation", $timerFile );
        print "$HtmlResult\n";
    }

    if ( $c->param('optlevel') eq 'LTO' ) {
        my $stats      = '';
        my $outputFile = getname(".gccld.out");
        my $timerFile  = getname(".gccld.time");
        $stats = "--stats --time-passes --info-output-file=$timerFile"
          if ( $c->param('showstats') );
        my $tmpFile = getname(".bc");
        try_run(
            "optimizing linker (llvm-ld)",
"llvm-ld $stats -o=$tmpFile $bytecodeFile > $outputFile 2>&1",
            $outputFile
        );
        system("mv $tmpFile.bc $bytecodeFile");
        system("rm $tmpFile");

        if ( $c->param('showstats') && -s $timerFile ) {
            my ( $UnhilightedResult, $HtmlResult ) =
              dumpFile( "Statistics for optimizing linker", $timerFile );
            print "$HtmlResult\n";
        }
    }

    print " Bytecode size is ", -s $bytecodeFile, " bytes.\n";

    my $targetLabel = $llvmTargets{$target}->{'label'};

    my $disassemblyFile;
    if ( $target eq 'llvm' ) {
        $disassemblyFile = getname(".ll");
        try_run( "llvm-dis",
            "llvm-dis -o=$disassemblyFile $bytecodeFile > $outputFile 2>&1",
            $outputFile );
    } else {
        $disassemblyFile = getname(".s");
        my $options = ( $c->param('optlevel') eq "None" ) ? "-O0" : "-O3";
        try_run( "llc",
            "llc -march=$target -asm-verbose $options -o=$disassemblyFile $bytecodeFile > $outputFile 2>&1",
            $outputFile );
    }

    if ( $c->param('cxxdemangle') ) {
        print " Demangling target output.\n";
        my $tmpFile = getname(".ll");
        system("c++filt < $disassemblyFile > $tmpFile 2>&1");
        system("mv $tmpFile $disassemblyFile");
    }

    my ( $UnhilightedResult, $HtmlResult );
    if ( -s $disassemblyFile ) {
        my $programName = ( $target eq 'llvm' ) ? 'disassembler' : 'static compiler';
        ( $UnhilightedResult, $HtmlResult ) =
          dumpFile( "Output from llvm $programName targeting $targetLabel", $disassemblyFile );
        if ( $target eq 'llvm' ) {
            $HtmlResult = syntaxHighlightLLVM($HtmlResult);
        }
        # It would be nice to support highlighting of other assembly files.
        print $HtmlResult;
    }
    else {
        print "<p>Hmm, that's weird, llvm-dis/llc didn't produce any output.</p>\n";
    }

    if ( $c->param('showbcanalysis') ) {
      my $analFile = getname(".bca");
      try_run( "llvm-bcanalyzer", "llvm-bcanalyzer $bytecodeFile > $analFile 2>&1", 
        $analFile);
    }

    # Get the source presented by the user to CGI, convert newline sequences to simple \n.
    my $actualsrc = $c->param('source');
    $actualsrc =~ s/\015\012/\n/go;
    # Don't log this or mail it if it is the default code.
    if ($actualsrc ne $defaultsrc) {
    addlog( $source, $pid, $UnhilightedResult );

    my ( $ip, $host, $lg, $lines );
    chomp( $lines = `wc -l < $inputFile` );
    $lg = $c->param('language');
    $ip = $c->remote_addr();
    chomp( $host = `host $ip` ) if $ip;
    if (0) {  # MAILING IS DISABLED
      mailto( $MAILADDR,
        "--- Query: ---\nFrom: ($ip) $host\nInput: $lines lines of $lg\n"
          . "C++ demangle = "
          . ( $c->param('cxxdemangle') ? 1 : 0 )
          . ", Opt level = "
          . ( $c->param('optlevel') ) . "\n\n"
          . ", Show stats = "
          . ( $c->param('showstats') ? 1 : 0 ) . "\n\n"
          . "--- Source: ---\n$source\n"
          . "--- Result: ---\n$UnhilightedResult\n" );
      }
    }
    unlink( $inputFile, $bytecodeFile, $outputFile, $disassemblyFile );
}

print $c->hr, "<address>$CONTACT_ADDRESS</address>", $c->end_html;
system("rm $ROOT/locked");
exit 0;
