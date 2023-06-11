## An error occurred while using find() and where() methods simultaneously in Eloquent Model classes

Ex: dd(Category::find($categoryId)->where('delete_flag', false)->get());
=> It will return all categories with delete_flag = false

## select() vs addSelect() in query builder

-   select() method: should be placed after the join clause (if any) and before the where clause (if any)
-   addSelect() method: should be placed after the where clause (if any)
