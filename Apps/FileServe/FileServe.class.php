<?php

class MFS_AppServer_Apps_FileServe
{
    private $path;

    public function __construct($path)
    {
        if (!is_dir($path))
            throw new Exception('"'.$path.'" is not a directory');

        $this->path = $path;
    }

    public function __invoke($ctx)
    {
        $path = $this->path.'/'.$ctx['env']['PATH_INFO'];

        if (!file_exists($path))
            return array(404, array('Content-type', 'text/plain'), 'File not found');

        if (!is_readable($path))
            return array(403, array('Content-type', 'text/plain'), 'Forbidden');

        return array(200, array('Content-type', self::getContentType($path)), file_get_contents($path));
    }

    private static function getContentType($path)
    {
        static $extensions = null;

        if (null === $extensions) {
            $extensions = array(
                '123' => 'application/vnd.lotus-1-2-3',
                '3dml' => 'text/vnd.in3d.3dml',
                '3g2' => 'video/3gpp2',
                '3gp' => 'video/3gpp',
                'ace' => 'application/x-ace-compressed',
                'acu' => 'application/vnd.acucobol',
                'acutc' => 'application/vnd.acucorp',
                'aep' => 'application/vnd.audiograph',
                'afp' => 'application/vnd.ibm.modcap',
                'ai' => 'application/postscript',
                'aif' => 'audio/x-aiff',
                'aifc' => 'audio/x-aiff',
                'aiff' => 'audio/x-aiff',
                'ami' => 'application/vnd.amiga.ami',
                'apr' => 'application/vnd.lotus-approach',
                'asc' => 'application/pgp-signature',
                'asf' => 'video/x-ms-asf',
                'asm' => 'text/x-asm',
                'aso' => 'application/vnd.accpac.simply.aso',
                'asx' => 'video/x-ms-asf',
                'atc' => 'application/vnd.acucorp',
                'atom' => 'application/atom+xml',
                'atomcat' => 'application/atomcat+xml',
                'atomsvc' => 'application/atomsvc+xml',
                'atx' => 'application/vnd.antix.game-component',
                'au' => 'audio/basic',
                'avi' => 'video/x-msvideo',
                'bat' => 'application/x-msdownload',
                'bcpio' => 'application/x-bcpio',
                'bdm' => 'application/vnd.syncml.dm+wbxml',
                'bh2' => 'application/vnd.fujitsu.oasysprs',
                'bmi' => 'application/vnd.bmi',
                'bmp' => 'image/bmp',
                'box' => 'application/vnd.previewsystems.box',
                'boz' => 'application/x-bzip2',
                'btif' => 'image/prs.btif',
                'bz' => 'application/x-bzip',
                'bz2' => 'application/x-bzip2',
                'c' => 'text/x-c',
                'c4d' => 'application/vnd.clonk.c4group',
                'c4f' => 'application/vnd.clonk.c4group',
                'c4g' => 'application/vnd.clonk.c4group',
                'c4p' => 'application/vnd.clonk.c4group',
                'c4u' => 'application/vnd.clonk.c4group',
                'cab' => 'application/vnd.ms-cab-compressed',
                'cc' => 'text/x-c',
                'ccxml' => 'application/ccxml+xml',
                'cdbcmsg' => 'application/vnd.contact.cmsg',
                'cdf' => 'application/x-netcdf',
                'cdkey' => 'application/vnd.mediastation.cdkey',
                'cdx' => 'chemical/x-cdx',
                'cdxml' => 'application/vnd.chemdraw+xml',
                'cdy' => 'application/vnd.cinderella',
                'cer' => 'application/pkix-cert',
                'cgm' => 'image/cgm',
                'chat' => 'application/x-chat',
                'chm' => 'application/vnd.ms-htmlhelp',
                'chrt' => 'application/vnd.kde.kchart',
                'cif' => 'chemical/x-cif',
                'cii' => 'application/vnd.anser-web-certificate-issue-initiation',
                'cil' => 'application/vnd.ms-artgalry',
                'cla' => 'application/vnd.claymore',
                'clkk' => 'application/vnd.crick.clicker.keyboard',
                'clkp' => 'application/vnd.crick.clicker.palette',
                'clkt' => 'application/vnd.crick.clicker.template',
                'clkw' => 'application/vnd.crick.clicker.wordbank',
                'clkx' => 'application/vnd.crick.clicker',
                'clp' => 'application/x-msclip',
                'cmc' => 'application/vnd.cosmocaller',
                'cmdf' => 'chemical/x-cmdf',
                'cml' => 'chemical/x-cml',
                'cmp' => 'application/vnd.yellowriver-custom-menu',
                'cmx' => 'image/x-cmx',
                'com' => 'application/x-msdownload',
                'conf' => 'text/plain',
                'cpio' => 'application/x-cpio',
                'cpp' => 'text/x-c',
                'cpt' => 'application/mac-compactpro',
                'crd' => 'application/x-mscardfile',
                'crl' => 'application/pkix-crl',
                'crt' => 'application/x-x509-ca-cert',
                'csh' => 'application/x-csh',
                'csml' => 'chemical/x-csml',
                'csp' => 'application/vnd.commonspace',
                'css' => 'text/css',
                'cst' => 'application/vnd.commonspace',
                'csv' => 'text/csv',
                'curl' => 'application/vnd.curl',
                'cww' => 'application/prs.cww',
                'cxx' => 'text/x-c',
                'daf' => 'application/vnd.mobius.daf',
                'davmount' => 'application/davmount+xml',
                'dcr' => 'application/x-director',
                'dd2' => 'application/vnd.oma.dd2+xml',
                'ddd' => 'application/vnd.fujixerox.ddd',
                'def' => 'text/plain',
                'der' => 'application/x-x509-ca-cert',
                'dfac' => 'application/vnd.dreamfactory',
                'dic' => 'text/x-c',
                'dir' => 'application/x-director',
                'dis' => 'application/vnd.mobius.dis',
                'djv' => 'image/vnd.djvu',
                'djvu' => 'image/vnd.djvu',
                'dll' => 'application/x-msdownload',
                'dna' => 'application/vnd.dna',
                'doc' => 'application/msword',
                'dot' => 'application/msword',
                'dp' => 'application/vnd.osgi.dp',
                'dpg' => 'application/vnd.dpgraph',
                'dsc' => 'text/prs.lines.tag',
                'dtd' => 'application/xml-dtd',
                'dvi' => 'application/x-dvi',
                'dwf' => 'model/vnd.dwf',
                'dwg' => 'image/vnd.dwg',
                'dxf' => 'image/vnd.dxf',
                'dxp' => 'application/vnd.spotfire.dxp',
                'dxr' => 'application/x-director',
                'ecelp4800' => 'audio/vnd.nuera.ecelp4800',
                'ecelp7470' => 'audio/vnd.nuera.ecelp7470',
                'ecelp9600' => 'audio/vnd.nuera.ecelp9600',
                'ecma' => 'application/ecmascript',
                'edm' => 'application/vnd.novadigm.edm',
                'edx' => 'application/vnd.novadigm.edx',
                'efif' => 'application/vnd.picsel',
                'ei6' => 'application/vnd.pg.osasli',
                'eml' => 'message/rfc822',
                'eol' => 'audio/vnd.digital-winds',
                'eot' => 'application/vnd.ms-fontobject',
                'eps' => 'application/postscript',
                'es3' => 'application/vnd.eszigno3+xml',
                'esf' => 'application/vnd.epson.esf',
                'et3' => 'application/vnd.eszigno3+xml',
                'etx' => 'text/x-setext',
                'exe' => 'application/x-msdownload',
                'ext' => 'application/vnd.novadigm.ext',
                'ez' => 'application/andrew-inset',
                'ez2' => 'application/vnd.ezpix-album',
                'ez3' => 'application/vnd.ezpix-package',
                'f' => 'text/x-fortran',
                'f77' => 'text/x-fortran',
                'f90' => 'text/x-fortran',
                'fbs' => 'image/vnd.fastbidsheet',
                'fdf' => 'application/vnd.fdf',
                'fe_launch' => 'application/vnd.denovo.fcselayout-link',
                'fg5' => 'application/vnd.fujitsu.oasysgp',
                'fgd' => 'application/x-director',
                'fli' => 'video/x-fli',
                'flo' => 'application/vnd.micrografx.flo',
                'flw' => 'application/vnd.kde.kivio',
                'flx' => 'text/vnd.fmi.flexstor',
                'fly' => 'text/vnd.fly',
                'fm' => 'application/vnd.framemaker',
                'fnc' => 'application/vnd.frogans.fnc',
                'for' => 'text/x-fortran',
                'fpx' => 'image/vnd.fpx',
                'frame' => 'application/vnd.framemaker',
                'fsc' => 'application/vnd.fsc.weblaunch',
                'fst' => 'image/vnd.fst',
                'ftc' => 'application/vnd.fluxtime.clip',
                'fti' => 'application/vnd.anser-web-funds-transfer-initiation',
                'fvt' => 'video/vnd.fvt',
                'fzs' => 'application/vnd.fuzzysheet',
                'g3' => 'image/g3fax',
                'gac' => 'application/vnd.groove-account',
                'gdl' => 'model/vnd.gdl',
                'ghf' => 'application/vnd.groove-help',
                'gif' => 'image/gif',
                'gim' => 'application/vnd.groove-identity-message',
                'gph' => 'application/vnd.flographit',
                'gqf' => 'application/vnd.grafeq',
                'gqs' => 'application/vnd.grafeq',
                'gram' => 'application/srgs',
                'grv' => 'application/vnd.groove-injector',
                'grxml' => 'application/srgs+xml',
                'gtar' => 'application/x-gtar',
                'gtm' => 'application/vnd.groove-tool-message',
                'gtw' => 'model/vnd.gtw',
                'h' => 'text/x-c',
                'h261' => 'video/h261',
                'h263' => 'video/h263',
                'h264' => 'video/h264',
                'hbci' => 'application/vnd.hbci',
                'hdf' => 'application/x-hdf',
                'hh' => 'text/x-c',
                'hlp' => 'application/winhlp',
                'hpgl' => 'application/vnd.hp-hpgl',
                'hpid' => 'application/vnd.hp-hpid',
                'hps' => 'application/vnd.hp-hps',
                'hqx' => 'application/mac-binhex40',
                'htke' => 'application/vnd.kenameaapp',
                'htm' => 'text/html',
                'html' => 'text/html',
                'hvd' => 'application/vnd.yamaha.hv-dic',
                'hvp' => 'application/vnd.yamaha.hv-voice',
                'hvs' => 'application/vnd.yamaha.hv-script',
                'ice' => 'x-conference/x-cooltalk',
                'ico' => 'image/x-icon',
                'ics' => 'text/calendar',
                'ief' => 'image/ief',
                'ifb' => 'text/calendar',
                'ifm' => 'application/vnd.shana.informed.formdata',
                'iges' => 'model/iges',
                'igl' => 'application/vnd.igloader',
                'igs' => 'model/iges',
                'igx' => 'application/vnd.micrografx.igx',
                'iif' => 'application/vnd.shana.informed.interchange',
                'imp' => 'application/vnd.accpac.simply.imp',
                'ims' => 'application/vnd.ms-ims',
                'in' => 'text/plain',
                'ipk' => 'application/vnd.shana.informed.package',
                'irm' => 'application/vnd.ibm.rights-management',
                'irp' => 'application/vnd.irepository.package+xml',
                'itp' => 'application/vnd.shana.informed.formtemplate',
                'ivp' => 'application/vnd.immervision-ivp',
                'ivu' => 'application/vnd.immervision-ivu',
                'jad' => 'text/vnd.sun.j2me.app-descriptor',
                'jam' => 'application/vnd.jam',
                'java' => 'text/x-java-source',
                'jisp' => 'application/vnd.jisp',
                'jlt' => 'application/vnd.hp-jlyt',
                'joda' => 'application/vnd.joost.joda-archive',
                'jpe' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'jpg' => 'image/jpeg',
                'jpgm' => 'video/jpm',
                'jpgv' => 'video/jpeg',
                'jpm' => 'video/jpm',
                'js' => 'application/javascript',
                'json' => 'application/json',
                'kar' => 'audio/midi',
                'karbon' => 'application/vnd.kde.karbon',
                'kfo' => 'application/vnd.kde.kformula',
                'kia' => 'application/vnd.kidspiration',
                'kml' => 'application/vnd.google-earth.kml+xml',
                'kmz' => 'application/vnd.google-earth.kmz',
                'kne' => 'application/vnd.kinar',
                'knp' => 'application/vnd.kinar',
                'kon' => 'application/vnd.kde.kontour',
                'kpr' => 'application/vnd.kde.kpresenter',
                'kpt' => 'application/vnd.kde.kpresenter',
                'ksp' => 'application/vnd.kde.kspread',
                'ktr' => 'application/vnd.kahootz',
                'ktz' => 'application/vnd.kahootz',
                'kwd' => 'application/vnd.kde.kword',
                'kwt' => 'application/vnd.kde.kword',
                'latex' => 'application/x-latex',
                'lbd' => 'application/vnd.llamagraphics.life-balance.desktop',
                'lbe' => 'application/vnd.llamagraphics.life-balance.exchange+xml',
                'les' => 'application/vnd.hhe.lesson-player',
                'list' => 'text/plain',
                'list3820' => 'application/vnd.ibm.modcap',
                'listafp' => 'application/vnd.ibm.modcap',
                'log' => 'text/plain',
                'lrm' => 'application/vnd.ms-lrm',
                'ltf' => 'application/vnd.frogans.ltf',
                'lvp' => 'audio/vnd.lucent.voice',
                'lwp' => 'application/vnd.lotus-wordpro',
                'm13' => 'application/x-msmediaview',
                'm14' => 'application/x-msmediaview',
                'm1v' => 'video/mpeg',
                'm2a' => 'audio/mpeg',
                'm2v' => 'video/mpeg',
                'm3a' => 'audio/mpeg',
                'm3u' => 'audio/x-mpegurl',
                'm4u' => 'video/vnd.mpegurl',
                'ma' => 'application/mathematica',
                'mag' => 'application/vnd.ecowin.chart',
                'maker' => 'application/vnd.framemaker',
                'man' => 'text/troff',
                'mathml' => 'application/mathml+xml',
                'mb' => 'application/mathematica',
                'mbk' => 'application/vnd.mobius.mbk',
                'mbox' => 'application/mbox',
                'mc1' => 'application/vnd.medcalcdata',
                'mcd' => 'application/vnd.mcd',
                'mdb' => 'application/x-msaccess',
                'mdi' => 'image/vnd.ms-modi',
                'me' => 'text/troff',
                'mesh' => 'model/mesh',
                'mfm' => 'application/vnd.mfmp',
                'mgz' => 'application/vnd.proteus.magazine',
                'mid' => 'audio/midi',
                'midi' => 'audio/midi',
                'mif' => 'application/vnd.mif',
                'mime' => 'message/rfc822',
                'mj2' => 'video/mj2',
                'mjp2' => 'video/mj2',
                'mlp' => 'application/vnd.dolby.mlp',
                'mmd' => 'application/vnd.chipnuts.karaoke-mmd',
                'mmf' => 'application/vnd.smaf',
                'mmr' => 'image/vnd.fujixerox.edmics-mmr',
                'mny' => 'application/x-msmoney',
                'mov' => 'video/quicktime',
                'movie' => 'video/x-sgi-movie',
                'mp2' => 'audio/mpeg',
                'mp2a' => 'audio/mpeg',
                'mp3' => 'audio/mpeg',
                'mp4' => 'video/mp4',
                'mp4a' => 'audio/mp4',
                'mp4s' => 'application/mp4',
                'mp4v' => 'video/mp4',
                'mpc' => 'application/vnd.mophun.certificate',
                'mpe' => 'video/mpeg',
                'mpeg' => 'video/mpeg',
                'mpg' => 'video/mpeg',
                'mpg4' => 'video/mp4',
                'mpga' => 'audio/mpeg',
                'mpkg' => 'application/vnd.apple.installer+xml',
                'mpm' => 'application/vnd.blueice.multipass',
                'mpn' => 'application/vnd.mophun.application',
                'mpp' => 'application/vnd.ms-project',
                'mpt' => 'application/vnd.ms-project',
                'mpy' => 'application/vnd.ibm.minipay',
                'mqy' => 'application/vnd.mobius.mqy',
                'mrc' => 'application/marc',
                'ms' => 'text/troff',
                'mscml' => 'application/mediaservercontrol+xml',
                'mseq' => 'application/vnd.mseq',
                'msf' => 'application/vnd.epson.msf',
                'msh' => 'model/mesh',
                'msi' => 'application/x-msdownload',
                'msl' => 'application/vnd.mobius.msl',
                'msty' => 'application/vnd.muvee.style',
                'mts' => 'model/vnd.mts',
                'mus' => 'application/vnd.musician',
                'mvb' => 'application/x-msmediaview',
                'mwf' => 'application/vnd.mfer',
                'mxf' => 'application/mxf',
                'mxl' => 'application/vnd.recordare.musicxml',
                'mxml' => 'application/xv+xml',
                'mxs' => 'application/vnd.triscape.mxs',
                'mxu' => 'video/vnd.mpegurl',
                'n-gage' => 'application/vnd.nokia.n-gage.symbian.install',
                'nb' => 'application/mathematica',
                'nc' => 'application/x-netcdf',
                'ngdat' => 'application/vnd.nokia.n-gage.data',
                'nlu' => 'application/vnd.neurolanguage.nlu',
                'nml' => 'application/vnd.enliven',
                'nnd' => 'application/vnd.noblenet-directory',
                'nns' => 'application/vnd.noblenet-sealer',
                'nnw' => 'application/vnd.noblenet-web',
                'npx' => 'image/vnd.net-fpx',
                'nsf' => 'application/vnd.lotus-notes',
                'oa2' => 'application/vnd.fujitsu.oasys2',
                'oa3' => 'application/vnd.fujitsu.oasys3',
                'oas' => 'application/vnd.fujitsu.oasys',
                'obd' => 'application/x-msbinder',
                'oda' => 'application/oda',
                'odc' => 'application/vnd.oasis.opendocument.chart',
                'odf' => 'application/vnd.oasis.opendocument.formula',
                'odg' => 'application/vnd.oasis.opendocument.graphics',
                'odi' => 'application/vnd.oasis.opendocument.image',
                'odp' => 'application/vnd.oasis.opendocument.presentation',
                'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
                'odt' => 'application/vnd.oasis.opendocument.text',
                'ogg' => 'application/ogg',
                'oprc' => 'application/vnd.palm',
                'org' => 'application/vnd.lotus-organizer',
                'otc' => 'application/vnd.oasis.opendocument.chart-template',
                'otf' => 'application/vnd.oasis.opendocument.formula-template',
                'otg' => 'application/vnd.oasis.opendocument.graphics-template',
                'oth' => 'application/vnd.oasis.opendocument.text-web',
                'oti' => 'application/vnd.oasis.opendocument.image-template',
                'otm' => 'application/vnd.oasis.opendocument.text-master',
                'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
                'ott' => 'application/vnd.oasis.opendocument.text-template',
                'oxt' => 'application/vnd.openofficeorg.extension',
                'p' => 'text/x-pascal',
                'p10' => 'application/pkcs10',
                'p12' => 'application/x-pkcs12',
                'p7b' => 'application/x-pkcs7-certificates',
                'p7c' => 'application/pkcs7-mime',
                'p7m' => 'application/pkcs7-mime',
                'p7r' => 'application/x-pkcs7-certreqresp',
                'p7s' => 'application/pkcs7-signature',
                'pas' => 'text/x-pascal',
                'pbd' => 'application/vnd.powerbuilder6',
                'pbm' => 'image/x-portable-bitmap',
                'pcl' => 'application/vnd.hp-pcl',
                'pclxl' => 'application/vnd.hp-pclxl',
                'pct' => 'image/x-pict',
                'pcx' => 'image/x-pcx',
                'pdb' => 'chemical/x-pdb',
                'pdf' => 'application/pdf',
                'pfr' => 'application/font-tdpfr',
                'pfx' => 'application/x-pkcs12',
                'pgm' => 'image/x-portable-graymap',
                'pgn' => 'application/x-chess-pgn',
                'pgp' => 'application/pgp-encrypted',
                'pic' => 'image/x-pict',
                'pki' => 'application/pkixcmp',
                'pkipath' => 'application/pkix-pkipath',
                'plb' => 'application/vnd.3gpp.pic-bw-large',
                'plc' => 'application/vnd.mobius.plc',
                'plf' => 'application/vnd.pocketlearn',
                'pls' => 'application/pls+xml',
                'pml' => 'application/vnd.ctc-posml',
                'png' => 'image/png',
                'pnm' => 'image/x-portable-anymap',
                'portpkg' => 'application/vnd.macports.portpkg',
                'pot' => 'application/vnd.ms-powerpoint',
                'ppd' => 'application/vnd.cups-ppd',
                'ppm' => 'image/x-portable-pixmap',
                'pps' => 'application/vnd.ms-powerpoint',
                'ppt' => 'application/vnd.ms-powerpoint',
                'pqa' => 'application/vnd.palm',
                'prc' => 'application/vnd.palm',
                'pre' => 'application/vnd.lotus-freelance',
                'prf' => 'application/pics-rules',
                'ps' => 'application/postscript',
                'psb' => 'application/vnd.3gpp.pic-bw-small',
                'psd' => 'image/vnd.adobe.photoshop',
                'ptid' => 'application/vnd.pvi.ptid1',
                'pub' => 'application/x-mspublisher',
                'pvb' => 'application/vnd.3gpp.pic-bw-var',
                'pwn' => 'application/vnd.3m.post-it-notes',
                'qam' => 'application/vnd.epson.quickanime',
                'qbo' => 'application/vnd.intu.qbo',
                'qfx' => 'application/vnd.intu.qfx',
                'qps' => 'application/vnd.publishare-delta-tree',
                'qt' => 'video/quicktime',
                'qwd' => 'application/vnd.quark.quarkxpress',
                'qwt' => 'application/vnd.quark.quarkxpress',
                'qxb' => 'application/vnd.quark.quarkxpress',
                'qxd' => 'application/vnd.quark.quarkxpress',
                'qxl' => 'application/vnd.quark.quarkxpress',
                'qxt' => 'application/vnd.quark.quarkxpress',
                'ra' => 'audio/x-pn-realaudio',
                'ram' => 'audio/x-pn-realaudio',
                'rar' => 'application/x-rar-compressed',
                'ras' => 'image/x-cmu-raster',
                'rcprofile' => 'application/vnd.ipunplugged.rcprofile',
                'rdf' => 'application/rdf+xml',
                'rdz' => 'application/vnd.data-vision.rdz',
                'rep' => 'application/vnd.businessobjects',
                'rgb' => 'image/x-rgb',
                'rif' => 'application/reginfo+xml',
                'rl' => 'application/resource-lists+xml',
                'rlc' => 'image/vnd.fujixerox.edmics-rlc',
                'rm' => 'application/vnd.rn-realmedia',
                'rmi' => 'audio/midi',
                'rmp' => 'audio/x-pn-realaudio-plugin',
                'rms' => 'application/vnd.jcp.javame.midlet-rms',
                'rnc' => 'application/relax-ng-compact-syntax',
                'roff' => 'text/troff',
                'rpss' => 'application/vnd.nokia.radio-presets',
                'rpst' => 'application/vnd.nokia.radio-preset',
                'rq' => 'application/sparql-query',
                'rs' => 'application/rls-services+xml',
                'rsd' => 'application/rsd+xml',
                'rss' => 'application/rss+xml',
                'rtf' => 'application/rtf',
                'rtx' => 'text/richtext',
                's' => 'text/x-asm',
                'saf' => 'application/vnd.yamaha.smaf-audio',
                'sbml' => 'application/sbml+xml',
                'sc' => 'application/vnd.ibm.secure-container',
                'scd' => 'application/x-msschedule',
                'scm' => 'application/vnd.lotus-screencam',
                'scq' => 'application/scvp-cv-request',
                'scs' => 'application/scvp-cv-response',
                'sdkd' => 'application/vnd.solent.sdkm+xml',
                'sdkm' => 'application/vnd.solent.sdkm+xml',
                'sdp' => 'application/sdp',
                'see' => 'application/vnd.seemail',
                'sema' => 'application/vnd.sema',
                'semd' => 'application/vnd.semd',
                'semf' => 'application/vnd.semf',
                'setpay' => 'application/set-payment-initiation',
                'setreg' => 'application/set-registration-initiation',
                'sfs' => 'application/vnd.spotfire.sfs',
                'sgm' => 'text/sgml',
                'sgml' => 'text/sgml',
                'sh' => 'application/x-sh',
                'shar' => 'application/x-shar',
                'shf' => 'application/shf+xml',
                'sig' => 'application/pgp-signature',
                'silo' => 'model/mesh',
                'sit' => 'application/x-stuffit',
                'sitx' => 'application/x-stuffitx',
                'skd' => 'application/vnd.koan',
                'skm' => 'application/vnd.koan',
                'skp' => 'application/vnd.koan',
                'skt' => 'application/vnd.koan',
                'slt' => 'application/vnd.epson.salt',
                'smi' => 'application/smil+xml',
                'smil' => 'application/smil+xml',
                'snd' => 'audio/basic',
                'spc' => 'application/x-pkcs7-certificates',
                'spf' => 'application/vnd.yamaha.smaf-phrase',
                'spl' => 'application/x-futuresplash',
                'spot' => 'text/vnd.in3d.spot',
                'spp' => 'application/scvp-vp-response',
                'spq' => 'application/scvp-vp-request',
                'src' => 'application/x-wais-source',
                'srx' => 'application/sparql-results+xml',
                'ssf' => 'application/vnd.epson.ssf',
                'ssml' => 'application/ssml+xml',
                'stf' => 'application/vnd.wt.stf',
                'stk' => 'application/hyperstudio',
                'str' => 'application/vnd.pg.format',
                'sus' => 'application/vnd.sus-calendar',
                'susp' => 'application/vnd.sus-calendar',
                'sv4cpio' => 'application/x-sv4cpio',
                'sv4crc' => 'application/x-sv4crc',
                'svd' => 'application/vnd.svd',
                'svg' => 'image/svg+xml',
                'svgz' => 'image/svg+xml',
                'swf' => 'application/x-shockwave-flash',
                't' => 'text/troff',
                'tao' => 'application/vnd.tao.intent-module-archive',
                'tar' => 'application/x-tar',
                'tcap' => 'application/vnd.3gpp2.tcap',
                'tcl' => 'application/x-tcl',
                'tex' => 'application/x-tex',
                'texi' => 'application/x-texinfo',
                'texinfo' => 'application/x-texinfo',
                'text' => 'text/plain',
                'tif' => 'image/tiff',
                'tiff' => 'image/tiff',
                'tmo' => 'application/vnd.tmobile-livetv',
                'torrent' => 'application/x-bittorrent',
                'tpl' => 'application/vnd.groove-tool-template',
                'tpt' => 'application/vnd.trid.tpt',
                'tr' => 'text/troff',
                'tra' => 'application/vnd.trueapp',
                'trm' => 'application/x-msterminal',
                'tsv' => 'text/tab-separated-values',
                'twd' => 'application/vnd.simtech-mindmapper',
                'twds' => 'application/vnd.simtech-mindmapper',
                'txd' => 'application/vnd.genomatix.tuxedo',
                'txf' => 'application/vnd.mobius.txf',
                'txt' => 'text/plain',
                'ufd' => 'application/vnd.ufdl',
                'ufdl' => 'application/vnd.ufdl',
                'umj' => 'application/vnd.umajin',
                'unityweb' => 'application/vnd.unity',
                'uoml' => 'application/vnd.uoml+xml',
                'uri' => 'text/uri-list',
                'uris' => 'text/uri-list',
                'urls' => 'text/uri-list',
                'ustar' => 'application/x-ustar',
                'utz' => 'application/vnd.uiq.theme',
                'uu' => 'text/x-uuencode',
                'vcd' => 'application/x-cdlink',
                'vcf' => 'text/x-vcard',
                'vcg' => 'application/vnd.groove-vcard',
                'vcs' => 'text/x-vcalendar',
                'vcx' => 'application/vnd.vcx',
                'vis' => 'application/vnd.visionary',
                'viv' => 'video/vnd.vivo',
                'vrml' => 'model/vrml',
                'vsd' => 'application/vnd.visio',
                'vsf' => 'application/vnd.vsf',
                'vss' => 'application/vnd.visio',
                'vst' => 'application/vnd.visio',
                'vsw' => 'application/vnd.visio',
                'vtu' => 'model/vnd.vtu',
                'vxml' => 'application/voicexml+xml',
                'wav' => 'audio/x-wav',
                'wax' => 'audio/x-ms-wax',
                'wbmp' => 'image/vnd.wap.wbmp',
                'wbs' => 'application/vnd.criticaltools.wbs+xml',
                'wbxml' => 'application/vnd.wap.wbxml',
                'wcm' => 'application/vnd.ms-works',
                'wdb' => 'application/vnd.ms-works',
                'wks' => 'application/vnd.ms-works',
                'wm' => 'video/x-ms-wm',
                'wma' => 'audio/x-ms-wma',
                'wmd' => 'application/x-ms-wmd',
                'wmf' => 'application/x-msmetafile',
                'wml' => 'text/vnd.wap.wml',
                'wmlc' => 'application/vnd.wap.wmlc',
                'wmls' => 'text/vnd.wap.wmlscript',
                'wmlsc' => 'application/vnd.wap.wmlscriptc',
                'wmv' => 'video/x-ms-wmv',
                'wmx' => 'video/x-ms-wmx',
                'wmz' => 'application/x-ms-wmz',
                'wpd' => 'application/vnd.wordperfect',
                'wpl' => 'application/vnd.ms-wpl',
                'wps' => 'application/vnd.ms-works',
                'wqd' => 'application/vnd.wqd',
                'wri' => 'application/x-mswrite',
                'wrl' => 'model/vrml',
                'wsdl' => 'application/wsdl+xml',
                'wspolicy' => 'application/wspolicy+xml',
                'wtb' => 'application/vnd.webturbo',
                'wvx' => 'video/x-ms-wvx',
                'x3d' => 'application/vnd.hzn-3d-crossword',
                'xar' => 'application/vnd.xara',
                'xbd' => 'application/vnd.fujixerox.docuworks.binder',
                'xbm' => 'image/x-xbitmap',
                'xdm' => 'application/vnd.syncml.dm+xml',
                'xdp' => 'application/vnd.adobe.xdp+xml',
                'xdw' => 'application/vnd.fujixerox.docuworks',
                'xenc' => 'application/xenc+xml',
                'xfdf' => 'application/vnd.adobe.xfdf',
                'xfdl' => 'application/vnd.xfdl',
                'xht' => 'application/xhtml+xml',
                'xhtml' => 'application/xhtml+xml',
                'xhvml' => 'application/xv+xml',
                'xif' => 'image/vnd.xiff',
                'xla' => 'application/vnd.ms-excel',
                'xlc' => 'application/vnd.ms-excel',
                'xlm' => 'application/vnd.ms-excel',
                'xls' => 'application/vnd.ms-excel',
                'xlt' => 'application/vnd.ms-excel',
                'xlw' => 'application/vnd.ms-excel',
                'xml' => 'application/xml',
                'xo' => 'application/vnd.olpc-sugar',
                'xop' => 'application/xop+xml',
                'xpm' => 'image/x-xpixmap',
                'xpr' => 'application/vnd.is-xpr',
                'xps' => 'application/vnd.ms-xpsdocument',
                'xpw' => 'application/vnd.intercon.formnet',
                'xpx' => 'application/vnd.intercon.formnet',
                'xsl' => 'application/xml',
                'xslt' => 'application/xslt+xml',
                'xsm' => 'application/vnd.syncml+xml',
                'xspf' => 'application/xspf+xml',
                'xul' => 'application/vnd.mozilla.xul+xml',
                'xvm' => 'application/xv+xml',
                'xvml' => 'application/xv+xml',
                'xwd' => 'image/x-xwindowdump',
                'xyz' => 'chemical/x-xyz',
                'zaz' => 'application/vnd.zzazz.deck+xml',
                'zip' => 'application/zip',
                'zmm' => 'application/vnd.handheld-entertainment+xml',
            );
        }

        $name = basename($path);
        $extension = substr($path, strrpos($path, '.') + 1);

        if (isset($extensions[$extension]))
            return $extensions[$extension];

        return 'text/plain';
    }
}
