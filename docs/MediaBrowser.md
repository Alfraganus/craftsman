## Init model:

```
use common\models\MediaBrowser;

$finder = new MediaBrowser();
...
```

## Custom config:

```
$config = array(
    'allowed_types' => ['images', 'media', '*.ttf'],
    'exclude_types' => ['*.php', '*.xml'],
);

$finder = new MediaBrowser();
$finder->config($config);
...
```

## Get files:

```
$path = BASE_PATH;
$path_url = 'https://www.domain.com/'

or

$path = UPLOADS_PATH;
$path_url = 'https://www.domain.com/uploads/'

$finder = new MediaBrowser();
$files = $finder->getFiles($path, $path_url);
...
```

## Get folders:

```
$path = BASE_PATH;
$path_url = 'https://www.domain.com/'

or

$path = UPLOADS_PATH;
$path_url = 'https://www.domain.com/uploads/'

$finder = new MediaBrowser();
$folders = $finder->getFolders($path, $path_url);
...
```

## Configurations:

**Allowed path**: (string, array)

Find files and directories by path

```
$config['in_path'] = array('first/path', 'second/path', 'images/icons');

or

$config['in_path'] = 'images/icons';
```

--

**Exclude path**: (string, array)

Excludes files by path

```
$config['not_path'] = array('first/path', 'second/path', 'images/icons');

or

$config['not_path'] = 'images/icons';
```

--

**Allowed types**: (string, array)

```
$config['allowed_types'] = array('audio', 'docs', 'files', 'images', 'media');

or

$config['allowed_types'] = array('*.ico', '*.jpg', '*.jpeg', '*.gif', '*.png');

or

$config['allowed_types'] = '*.jpg';
```

--

**Exclude types**: (string, array) 

Default: ['docs', 'files', 'images', 'media']

```
$config['exclude_types'] = array('docs', 'files', 'images', 'media');

or

$config['exclude_types'] = array('*.ico', '*.jpg', '*.jpeg', '*.gif', '*.png');

or

$config['exclude_types'] = '*.jpg';
```

--

**Ignore version control files**: (boolean) 

Default: false

VCS files are ignored by default when looking for files and directories, but you can change it.

```
$config['ignore_vcs'] = false;
```

--

**Ignore unreadable dirs**: (boolean) 

Default: true

Ignore directories that you don’t have permission to read.

```
$config['ignore_unreadable_dirs'] = true;
```

--

**Find by date**: (string, array)

Find files by last modified dates

```
$config['date'] = '>= 2018-01-01';

or

$config['date'] = ['>= 2018-01-01', '<= 2018-12-31'];
```

--

**Find by size**: (string, array)

Find files by size

```
$config['size'] = '>= 1K';

or

$config['size'] = ['>= 1K', '<= 2K'];
```

--

**Sort results**: (string)

Sort the results by name or by type:

- Sort by name: name (default value)
- Sort by type: type
- Sort by accessed time: accessed_time
- Sort by changed time: changed_time
- Sort by modified time: modified_time

```
$config['sort_by'] = 'name';
$config['sort_type'] = 'asc';
```

--

**Directory depth**: (string, array)

By default, the Finder recursively traverses directories. Restrict the depth of traversing with depth:

```
$config['depth'] = '== 0';

or

$config['depth'] = '< 3';

or

$config['depth'] = ['> 2', '< 5'];
```

--

