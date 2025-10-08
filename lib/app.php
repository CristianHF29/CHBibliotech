<?php

session_start();

if (!function_exists('str_contains')) {
  function str_contains($haystack, $needle) { return $needle === '' || strpos($haystack, $needle) !== false; }
}

interface Searchable {
  public function matches(string $q): bool;
}

abstract class Entity {
  abstract public function label(): string;
}

class Book extends Entity implements Searchable {
  public function __construct(
    public int $id,
    public string $title,
    public string $author,
    public ?string $category = null,
    public ?int $year = null,
    public ?string $description = null,
    public ?string $image_url = null,
    public int $copies_total = 1,
    public int $copies_available = 1
  ) {}

  public function matches(string $q): bool {
    if ($q === '') return true;
    $q = mb_strtolower($q, 'UTF-8');
    return str_contains(mb_strtolower($this->title, 'UTF-8'), $q)
        || str_contains(mb_strtolower($this->author, 'UTF-8'), $q)
        || str_contains(mb_strtolower($this->category ?? '', 'UTF-8'), $q);
  }

  public function label(): string { return 'Libro'; }

  public function availableBool(): int {
    return $this->copies_available > 0 ? 1 : 0;
  }

  public function toArray(): array {
    return [
      'id' => $this->id,
      'title' => $this->title,
      'author' => $this->author,
      'category' => $this->category,
      'year' => $this->year,
      'description' => $this->description,
      'image_url' => $this->image_url,
      'copies_total' => $this->copies_total,
      'copies_available' => $this->copies_available,
      'available' => $this->availableBool(),
      'label' => $this->label(),
    ];
  }

  public static function fromArray(array $a): Book {
    $total = isset($a['copies_total']) ? (int)$a['copies_total'] : 1;
    $avail = isset($a['copies_available']) ? (int)$a['copies_available'] : ($a['available'] ?? 1 ? $total : 0);
    if ($avail > $total) $avail = $total;
    return new Book(
      id: (int)$a['id'],
      title: (string)$a['title'],
      author: (string)$a['author'],
      category: $a['category'] ?? null,
      year: isset($a['year']) && $a['year'] !== '' ? (int)$a['year'] : null,
      description: $a['description'] ?? null,
      image_url: $a['image_url'] ?? null,
      copies_total: max(0, $total),
      copies_available: max(0, $avail)
    );
  }
}

class RareBook extends Book {
  public function label(): string { return 'Libro Raro'; }
}

class Loan extends Entity {
  public function __construct(
    public int $id,
    public int $book_id,
    public string $user,
    public string $out_date,
    public string $due_date,
    public string $status = 'En curso'
  ) {}

  public function label(): string { return 'Préstamo'; }

  public function toArray(): array {
    return [
      'id' => $this->id,
      'book_id' => $this->book_id,
      'user' => $this->user,
      'out_date' => $this->out_date,
      'due_date' => $this->due_date,
      'status' => $this->status,
      'label' => $this->label(),
    ];
  }

  public static function fromArray(array $a): Loan {
    return new Loan(
      id: (int)$a['id'],
      book_id: (int)$a['book_id'],
      user: (string)$a['user'],
      out_date: (string)$a['out_date'],
      due_date: (string)$a['due_date'],
      status: (string)($a['status'] ?? 'En curso')
    );
  }
}

if (!isset($_SESSION['books'])) {
  $_SESSION['books'] = [
    [
      'id'=>1,
      'title'=>'El nombre del viento',
      'author'=>'Patrick Rothfuss',
      'category'=>'Fantasía',
      'year'=>2007,
      'description'=>'Crónica del asesino de reyes, día uno.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780756404741-L.jpg',
      'copies_total'=>3,
      'copies_available'=>3,
      'available'=>1
    ],
    [
      'id'=>2,
      'title'=>'Cien años de soledad',
      'author'=>'Gabriel García Márquez',
      'category'=>'Realismo mágico',
      'year'=>1967,
      'description'=>'La saga de los Buendía en Macondo.',
      'image_url'=>'https://f.fcdn.app/imgs/852bde/lemon.com.uy/lemouy/b644/original/catalogo/9789915681337_9789915681337_1/2000-2000/cien-anos-de-soledad-cien-anos-de-soledad.jpg',
      'copies_total'=>2,
      'copies_available'=>2,
      'available'=>1
    ],
    [
      'id'=>3,
      'title'=>'Clean Code',
      'author'=>'Robert C. Martin',
      'category'=>'Tecnología',
      'year'=>2008,
      'description'=>'Principios y prácticas para escribir buen código.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780132350884-L.jpg',
      'copies_total'=>4,
      'copies_available'=>4,
      'available'=>1
    ],
    [
      'id'=>4,
      'title'=>'La sombra del viento',
      'author'=>'Carlos Ruiz Zafón',
      'category'=>'Misterio',
      'year'=>2001,
      'description'=>'Cementerio de los Libros Olvidados.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9788408172178-L.jpg',
      'copies_total'=>3,
      'copies_available'=>3,
      'available'=>1
    ],
    [
      'id'=>5,
      'title'=>'El Alquimista',
      'author'=>'Paulo Coelho',
      'category'=>'Filosofía',
      'year'=>1988,
      'description'=>'Una fábula sobre seguir los sueños y el destino personal.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780061122415-L.jpg',
      'copies_total'=>2,
      'copies_available'=>2,
      'available'=>1
    ],
    [
      'id'=>6,
      'title'=>'1984',
      'author'=>'George Orwell',
      'category'=>'Distopía',
      'year'=>1949,
      'description'=>'Una visión inquietante del control y la vigilancia totalitaria.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780451524935-L.jpg',
      'copies_total'=>5,
      'copies_available'=>5,
      'available'=>1
    ],
    [
      'id'=>7,
      'title'=>'Don Quijote de la Mancha',
      'author'=>'Miguel de Cervantes',
      'category'=>'Clásico',
      'year'=>1605,
      'description'=>'Las aventuras del ingenioso hidalgo y su fiel escudero Sancho Panza.',
      'image_url'=>'https://imgv2-2-f.scribdassets.com/img/word_document/315233472/original/216x287/36867d8558/1757996730?v=1',
      'copies_total'=>1,
      'copies_available'=>1,
      'available'=>1
    ],
    [
      'id'=>8,
      'title'=>'El Principito',
      'author'=>'Antoine de Saint-Exupéry',
      'category'=>'Fábula',
      'year'=>1943,
      'description'=>'Una historia sobre la inocencia, la amistad y lo esencial de la vida.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780156012195-L.jpg',
      'copies_total'=>3,
      'copies_available'=>3,
      'available'=>1
    ],
    [
      'id'=>9,
      'title'=>'Los Juegos del Hambre',
      'author'=>'Suzanne Collins',
      'category'=>'Ciencia ficción',
      'year'=>2008,
      'description'=>'Una competencia mortal en un futuro distópico donde solo uno puede sobrevivir.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780439023528-L.jpg',
      'copies_total'=>10,
      'copies_available'=>10,
      'available'=>1
    ],
    [
      'id'=>10,
      'title'=>'Harry Potter y la piedra filosofal',
      'author'=>'J.K. Rowling',
      'category'=>'Fantasía',
      'year'=>1997,
      'description'=>'El inicio de la saga del joven mago que cambió el mundo literario.',
      'image_url'=>'https://covers.openlibrary.org/b/isbn/9780747532699-L.jpg',
      'copies_total'=>6,
      'copies_available'=>6,
      'available'=>1
    ],
  ];
  $_SESSION['loans'] = [];
  $_SESSION['next_book_id'] = max(array_column($_SESSION['books'], 'id')) + 1;
  $_SESSION['next_loan_id'] = 1;
}

final class Mappers {
  public static function toBook(array $row): Book {
    $isRare = (isset($row['year']) && $row['year'] && (int)$row['year'] < 1900)
              || (isset($row['category']) && in_array(mb_strtolower($row['category'],'UTF-8'), ['clásico','clasico']));
    $b = $isRare ? new RareBook(
      id:(int)$row['id'],
      title:(string)$row['title'],
      author:(string)$row['author'],
      category:$row['category'] ?? null,
      year:isset($row['year']) && $row['year'] !== '' ? (int)$row['year'] : null,
      description:$row['description'] ?? null,
      image_url:$row['image_url'] ?? null,
      copies_total: isset($row['copies_total']) ? (int)$row['copies_total'] : 1,
      copies_available: isset($row['copies_available']) ? (int)$row['copies_available'] : (($row['available'] ?? 1) ? ((int)($row['copies_total'] ?? 1)) : 0)
    ) : Book::fromArray($row);
    return $b;
  }

  public static function fromBook(Book $b): array { return $b->toArray(); }

  public static function toLoan(array $row): Loan { return Loan::fromArray($row); }

  public static function fromLoan(Loan $l): array { return $l->toArray(); }
}

class Books {
  public static function all(?string $q = null): array {
    $objects = array_map(fn($r)=> Mappers::toBook($r), $_SESSION['books']);
    if ($q) {
      $objects = array_values(array_filter($objects, fn(Book $b)=> $b->matches($q)));
    }
    usort($objects, fn(Book $a, Book $b)=> $b->id <=> $a->id);
    return array_map(fn(Book $b)=> $b->toArray(), $objects);
  }

  public static function find(int $id): ?array {
    foreach ($_SESSION['books'] as $r) {
      if ((int)$r['id'] === $id) return Mappers::toBook($r)->toArray();
    }
    return null;
  }

  public static function create(array $d): int {
    $id = $_SESSION['next_book_id']++;
    $total = isset($d['copies_total']) && $d['copies_total'] !== '' ? max(0,(int)$d['copies_total']) : 1;
    $book = new Book(
      id:$id,
      title:trim($d['title']),
      author:trim($d['author']),
      category:$d['category'] ?? null,
      year:($d['year']!=='') ? (int)$d['year'] : null,
      description:$d['description'] ?? null,
      image_url:$d['image_url'] ?? null,
      copies_total:$total,
      copies_available:$total
    );
    $_SESSION['books'][] = $book->toArray();
    return $id;
  }

  public static function update(int $id, array $d): void {
    foreach ($_SESSION['books'] as &$r) {
      if ((int)$r['id'] === $id) {
        $book = Mappers::toBook($r);
        $book->title = trim($d['title']);
        $book->author = trim($d['author']);
        $book->category = $d['category'] ?? null;
        $book->year = ($d['year']!=='') ? (int)$d['year'] : null;
        $book->description = $d['description'] ?? null;
        $book->image_url = $d['image_url'] ?? null;
        if (isset($d['copies_total']) && $d['copies_total'] !== '') {
          $newTotal = max(0,(int)$d['copies_total']);
          $diff = $newTotal - $book->copies_total;
          $book->copies_total = $newTotal;
          $book->copies_available = max(0, min($book->copies_total, $book->copies_available + $diff));
        }
        $r = $book->toArray();
        break;
      }
    }
    unset($r);
  }

  public static function delete(int $id): void {
    foreach ($_SESSION['loans'] as $l) {
      if ((int)$l['book_id'] === $id && ($l['status'] ?? '') === 'En curso') {
        throw new Exception('No puedes eliminar: el libro tiene un préstamo en curso.');
      }
    }
    $_SESSION['books'] = array_values(array_filter($_SESSION['books'], fn($r)=> (int)$r['id'] !== $id));
  }

  public static function adjustCopiesAvailable(int $id, int $delta): void {
    foreach ($_SESSION['books'] as &$r) {
      if ((int)$r['id'] === $id) {
        $b = Mappers::toBook($r);
        $b->copies_available = max(0, min($b->copies_total, $b->copies_available + $delta));
        $r = $b->toArray();
        break;
      }
    }
    unset($r);
  }

  public static function available(): array {
    $all = self::all();
    return array_values(array_filter($all, fn($r)=> (int)($r['copies_available'] ?? 0) > 0));
  }

  public static function stats(): array {
    $all = self::all();
    $total = count($all);
    $available = count(array_filter($all, fn($r)=> (int)($r['copies_available'] ?? 0) > 0));
    $loans = count(array_filter($_SESSION['loans'], fn($l)=> ($l['status'] ?? '') === 'En curso'));
    return compact('total','available','loans');
  }
}

class Loans {
  public static function all(): array {
    $out = [];
    foreach ($_SESSION['loans'] as $row) {
      $l = Mappers::toLoan($row)->toArray();
      $book = Books::find((int)$l['book_id']);
      $l['book_title'] = $book['title'] ?? 'Libro eliminado';
      $out[] = $l;
    }
    usort($out, fn($a,$b)=> $b['id'] <=> $a['id']);
    return $out;
  }

  public static function create(int $book_id, string $user, string $out_date, string $due_date): int {
    $book = Books::find($book_id);
    if (!$book || (int)($book['copies_available'] ?? 0) <= 0) throw new Exception('Libro no disponible.');

    $id = $_SESSION['next_loan_id']++;
    $loan = new Loan($id, $book_id, $user, $out_date, $due_date, 'En curso');
    $_SESSION['loans'][] = $loan->toArray();
    Books::adjustCopiesAvailable($book_id, -1);
    return $id;
  }

  public static function markReturned(int $loan_id): void {
    foreach ($_SESSION['loans'] as &$row) {
      if ((int)$row['id'] === $loan_id && ($row['status'] ?? '') !== 'Devuelto') {
        $l = Mappers::toLoan($row);
        $l->status = 'Devuelto';
        $row = $l->toArray();
        Books::adjustCopiesAvailable((int)$l->book_id, +1);
        break;
      }
    }
    unset($row);
  }
}