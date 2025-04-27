export interface MenuItemType {
    id: string
    menu_id: string
    parent_id?: string | null
    name?: string
    icon?: string
    order: number
    type: 'custom' | 'page' | 'category' | 'post'
    page_id: string | null
    post_id: string | null
    category_id: string | null
    url?: string
    class_name?: string
    navigate?: boolean
    new_tab?: boolean
    children?: MenuItemType[]
}