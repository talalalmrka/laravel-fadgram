export interface MenuItemType {
    id: string
    name: string
    url?: string
    type: 'custom' | 'page' | 'category' | 'post'
    icon?: string
    class_name?: string
    new_tab?: boolean
    navigate?: boolean
    parent_id?: string | null
    order: number
    children?: MenuItemType[]
}