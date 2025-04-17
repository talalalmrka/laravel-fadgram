export interface MenuType{
    id: string
    name: string
    position: string
    class_name: string
    items?: MenuItemType[]
}
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

  export interface MenuItemPayload extends Omit<MenuItemType, 'children' | 'id'> {
    id?: string
    children?: MenuItemPayload[]
  }

  export interface OptionType {
    label: string
    value: string
  }
