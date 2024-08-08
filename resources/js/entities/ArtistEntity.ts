import type { SongEntity } from '@/entities'

export interface ArtistEntity {
    id: number,
    title: string,
    songs: SongEntity,
}
