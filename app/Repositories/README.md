An error occurred while using find() and where() methods simultaneously in Eloquent Model classes
Ex: dd(Category::find($categoryId)->where('delete_flag', false)->get());
=> It will return all categories with delete_flag = false
