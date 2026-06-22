@extends('layouts.owner')

@section('title', 'Managee Owner - Ubah Properti: ' . $property->title)
@section('page_title', 'Ubah Properti')

@section('content')

<div class="owner-form-container" style="background: white; border: 1px solid var(--border); border-radius: var(--radius-lg); padding: 2.5rem; max-width: 850px; margin: 0 auto; box-shadow: var(--shadow-sm);">
    <div class="form-header" style="position: relative; margin-bottom: 2rem;">
        <a href="{{ route('owner.properties.index') }}" style="position: absolute; right: 0; top: 0; color: var(--text-muted); transition: var(--transition);">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </a>
        <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--primary); margin: 0; line-height: 1.2;">Ubah Rincian Unit Properti</h3>
    </div>

    <!-- Wizard Steps Indicator -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem; position: relative;">
        <div style="position: absolute; top: 50%; left: 0; right: 0; height: 2px; background: #e2e8f0; z-index: 1;"></div>
        <div id="step-indicator-line" style="position: absolute; top: 50%; left: 0; width: 0%; height: 2px; background: var(--primary); z-index: 1; transition: all 0.3s ease;"></div>
        
        <div class="step-indicator active" data-step="1" style="display: flex; flex-direction: column; align-items: center; z-index: 2; position: relative;">
            <div class="step-circle" style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; border: 3px solid white; transition: all 0.3s ease; box-shadow: var(--shadow-sm);">1</div>
            <span style="font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; color: var(--primary);">Informasi Dasar</span>
        </div>
        <div class="step-indicator" data-step="2" style="display: flex; flex-direction: column; align-items: center; z-index: 2; position: relative;">
            <div class="step-circle" style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0; color: var(--text-muted); display: flex; align-items: center; justify-content: center; font-weight: 700; border: 3px solid white; transition: all 0.3s ease;">2</div>
            <span style="font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; color: var(--text-muted);">Spesifikasi & Fasilitas</span>
        </div>
        <div class="step-indicator" data-step="3" style="display: flex; flex-direction: column; align-items: center; z-index: 2; position: relative;">
            <div class="step-circle" style="width: 36px; height: 36px; border-radius: 50%; background: #e2e8f0; color: var(--text-muted); display: flex; align-items: center; justify-content: center; font-weight: 700; border: 3px solid white; transition: all 0.3s ease;">3</div>
            <span style="font-size: 0.8rem; font-weight: 600; margin-top: 0.5rem; color: var(--text-muted);">Foto Properti</span>
        </div>
    </div>

    @if ($errors->any())
        <div style="background-color: #fee2e2; border: 1px solid #fca5a5; color: #ef4444; padding: 1rem 1.5rem; border-radius: var(--radius-md); font-size: 0.9rem; font-weight: 600; margin-bottom: 1.5rem; font-family: 'Outfit', sans-serif;">
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('owner.properties.update', $property->id) }}" method="POST" id="property-form" enctype="multipart/form-data" class="owner-form" style="display: flex; flex-direction: column; gap: 2rem;">
        @csrf
        @method('PUT')
        
        <!-- STEP 1: INFORMASI DASAR -->
        <div class="wizard-step" id="wizard-step-1">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Informasi Dasar</h4>
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <div class="form-group">
                    <label for="title" style="font-weight: 600; font-size: 0.9rem;">Nama Properti *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $property->title) }}" placeholder="Tulis nama properti..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;" required>
                    @error('title')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-row" style="display: flex; gap: 1.5rem;">
                    <div class="form-group" style="flex: 1;">
                        <label for="type" style="font-weight: 600; font-size: 0.9rem;">Tipe Properti *</label>
                        <select id="type" name="type" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem; background: white;" required>
                            <option value="" disabled>Pilih Tipe</option>
                            <option value="apartemen" {{ old('type', $property->type) == 'apartemen' ? 'selected' : '' }}>Apartemen</option>
                            <option value="villa" {{ old('type', $property->type) == 'villa' ? 'selected' : '' }}>Villa</option>
                            <option value="rumah" {{ old('type', $property->type) == 'rumah' ? 'selected' : '' }}>Rumah</option>
                        </select>
                        @error('type')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group" style="flex: 1;">
                        <label for="price" style="font-weight: 600; font-size: 0.9rem;">Harga Sewa Per Malam (Rp) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $property->price) }}" placeholder="Contoh: 12500000" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;" required>
                        @error('price')
                            <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="location" style="font-weight: 600; font-size: 0.9rem;">Kota / Wilayah Utama *</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $property->location) }}" placeholder="Contoh: Ubud, Bali atau Kuta, Bali" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;" required>
                    @error('location')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" style="font-weight: 600; font-size: 0.9rem;">Alamat Lengkap *</label>
                    <input type="text" id="address" name="address" value="{{ old('address', $property->address) }}" placeholder="Tulis alamat lengkap..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;" required>
                    @error('address')
                        <span style="color: #ef4444; font-size: 0.85rem; margin-top: 0.25rem; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" style="font-weight: 600; font-size: 0.9rem;">Deskripsi</label>
                    <textarea id="description" name="description" rows="5" placeholder="Tulis deskripsi rinci properti..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem; font-family: inherit;">{{ old('description', $property->description) }}</textarea>
                </div>
            </div>
        </div>

        <!-- STEP 2: SPESIFIKASI & FASILITAS -->
        <div class="wizard-step" id="wizard-step-2" style="display: none;">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Spesifikasi Fisik</h4>
            <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2rem;">
                <div class="form-row" style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label for="bedrooms" style="font-weight: 600; font-size: 0.9rem;">Kamar Tidur</label>
                        <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" placeholder="Jumlah..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="bathrooms" style="font-weight: 600; font-size: 0.9rem;">Kamar Mandi</label>
                        <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" placeholder="Jumlah..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="area" style="font-weight: 600; font-size: 0.9rem;">Luas (m2) *</label>
                        <input type="number" id="area" name="area" value="{{ old('area', $property->area) }}" placeholder="Luas..." style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;" required>
                    </div>
                </div>

                <div class="form-row" style="display: flex; gap: 1.5rem;">
                    <div class="form-group" style="flex: 1;">
                        <label for="floors" style="font-weight: 600; font-size: 0.9rem;">Jumlah Lantai</label>
                        <input type="number" id="floors" name="floors" value="{{ old('floors', $property->floors) }}" placeholder="Contoh: 2" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="garage" style="font-weight: 600; font-size: 0.9rem;">Garasi</label>
                        <input type="text" id="garage" name="garage" value="{{ old('garage', $property->garage) }}" placeholder="Contoh: 1 Mobil, 2 Motor" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                </div>

                <div class="form-row" style="display: flex; gap: 1.5rem;">
                    <div class="form-group" style="flex: 1;">
                        <label for="year_built" style="font-weight: 600; font-size: 0.9rem;">Tahun Bangun</label>
                        <input type="number" id="year_built" name="year_built" value="{{ old('year_built', $property->year_built) }}" placeholder="Contoh: 2021" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="certificate" style="font-weight: 600; font-size: 0.9rem;">Sertifikat</label>
                        <input type="text" id="certificate" name="certificate" value="{{ old('certificate', $property->certificate) }}" placeholder="Contoh: SHM, HGB" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                </div>

                <div class="form-row" style="display: flex; gap: 1.5rem;">
                    <div class="form-group" style="flex: 1;">
                        <label for="electricity" style="font-weight: 600; font-size: 0.9rem;">Daya Listrik (Watt)</label>
                        <input type="number" id="electricity" name="electricity" value="{{ old('electricity', $property->electricity) }}" placeholder="Contoh: 2200" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label for="water_source" style="font-weight: 600; font-size: 0.9rem;">Sumber Air</label>
                        <input type="text" id="water_source" name="water_source" value="{{ old('water_source', $property->water_source) }}" placeholder="Contoh: PDAM, Sumur Bor" style="width: 100%; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none; margin-top: 0.25rem;">
                    </div>
                </div>
            </div>

            <!-- FASILITAS -->
            @php
                $currentFacilities = is_array($property->facilities) ? $property->facilities : [];
            @endphp
            <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Fasilitas Properti</h4>
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                <!-- Column 1 -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="AC" {{ in_array('AC', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>AC</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Wi-Fi" {{ in_array('Wi-Fi', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Wi-Fi</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Kolam Renang" {{ in_array('Kolam Renang', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Kolam Renang</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Taman" {{ in_array('Taman', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Taman</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Keamanan 24 Jam" {{ in_array('Keamanan 24 Jam', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Keamanan 24 Jam</span>
                    </label>
                </div>
                <!-- Column 2 -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Dapur" {{ in_array('Dapur', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Dapur</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Laundry" {{ in_array('Laundry', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Laundry</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Playground" {{ in_array('Playground', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Playground</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Furniture" {{ in_array('Furniture', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Furniture</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="TV Kabel" {{ in_array('TV Kabel', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>TV Kabel</span>
                    </label>
                </div>
                <!-- Column 3 -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Gym" {{ in_array('Gym', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Gym</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Garasi" {{ in_array('Garasi', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Garasi</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="CCTV" {{ in_array('CCTV', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>CCTV</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Balkon" {{ in_array('Balkon', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Balkon</span>
                    </label>
                    <label style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.9rem; cursor: pointer;">
                        <input type="checkbox" name="facilities[]" value="Parkir Motor" {{ in_array('Parkir Motor', old('facilities', $currentFacilities)) ? 'checked' : '' }} style="accent-color: var(--primary);">
                        <span>Parkir Motor</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- STEP 3: FOTO PROPERTI -->
        <div class="wizard-step" id="wizard-step-3" style="display: none;">
            <h4 style="font-size: 1.1rem; font-weight: 700; color: var(--primary); margin-bottom: 1.25rem; border-bottom: 1px solid var(--border); padding-bottom: 0.5rem;">Unggah Galeri Foto</h4>
            
            <!-- Dual Options: Local Files OR Web URLs -->
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                
                <!-- Option A: Local File Upload -->
                <div style="background: var(--bg-light); border: 2px dashed var(--border); border-radius: var(--radius-lg); padding: 2rem; text-align: center; position: relative; cursor: pointer; transition: var(--transition);" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='var(--border)'">
                    <input type="file" id="images-files-input" name="images_files[]" multiple accept="image/*" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                    <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2" style="margin-bottom: 0.5rem;"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                    <p style="font-weight: 600; font-size: 0.95rem; margin-bottom: 0.25rem; color: var(--text-main);">Pilih Foto Baru dari Komputer Anda</p>
                    <p style="font-size: 0.8rem; color: var(--text-muted);">Mendukung banyak file gambar sekaligus (Maks. 5MB per file)</p>
                </div>

                <div style="text-align: center; color: var(--text-muted); font-size: 0.85rem; font-weight: 600;">atau</div>

                <!-- Option B: Paste URLs -->
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    <label for="photo-url-input" style="font-weight: 600; font-size: 0.9rem;">Tempel URL Gambar Eksternal</label>
                    <div style="display: flex; gap: 0.5rem; align-items: center;">
                        <input type="url" id="photo-url-input" placeholder="Masukkan URL Gambar (contoh: https://images.unsplash.com/...)" style="flex: 1; padding: 0.75rem; border: 1px solid var(--border); border-radius: var(--radius-md); outline: none;">
                        <button type="button" id="btn-add-url" style="background-color: var(--primary); color: white; border: none; width: 44px; height: 44px; border-radius: var(--radius-md); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: var(--transition);">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Previews container for both files and pasted URLs -->
            <div style="margin-top: 1.5rem;">
                <span style="font-size: 0.9rem; font-weight: 600; color: var(--text-main); display: block; margin-bottom: 0.75rem;">Foto Terdaftar & Baru:</span>
                <div id="combined-photos-preview" style="display: flex; flex-wrap: wrap; gap: 1rem;">
                    <!-- Previews populated by JS -->
                </div>
            </div>

            <!-- Hidden URL fields container -->
            <div id="hidden-urls-container"></div>
        </div>

        <!-- NAVIGATION CONTROLS -->
        <div class="form-actions" style="display: flex; justify-content: space-between; gap: 1rem; margin-top: 1.5rem; border-top: 1px solid var(--border); padding-top: 1.5rem;">
            <button type="button" id="btn-prev" class="btn" style="background-color: #E2E8F0; color: var(--text-main); border: none; padding: 0.75rem 2rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; transition: var(--transition); display: none;">Sebelumnya</button>
            <a href="{{ route('owner.properties.index') }}" id="btn-cancel" class="btn" style="background-color: #E2E8F0; color: var(--text-main); text-decoration: none; padding: 0.75rem 2rem; border-radius: var(--radius-md); font-weight: 600; transition: var(--transition);">Batal</a>
            
            <div style="margin-left: auto;">
                <button type="button" id="btn-next" class="btn" style="background-color: var(--primary); color: white; border: none; padding: 0.75rem 2rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; transition: var(--transition);">Berikutnya</button>
                <button type="submit" id="btn-submit" class="btn" style="background-color: #DDA853; color: white; border: none; padding: 0.75rem 2rem; border-radius: var(--radius-md); font-weight: 600; cursor: pointer; transition: var(--transition); display: none;">Simpan Perubahan</button>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let currentStep = 1;
    const totalSteps = 3;

    // Elements
    const steps = document.querySelectorAll('.wizard-step');
    const stepIndicators = document.querySelectorAll('.step-indicator');
    const indicatorLine = document.getElementById('step-indicator-line');
    const btnPrev = document.getElementById('btn-prev');
    const btnNext = document.getElementById('btn-next');
    const btnCancel = document.getElementById('btn-cancel');
    const btnSubmit = document.getElementById('btn-submit');

    // Forms validation items
    const titleInput = document.getElementById('title');
    const typeSelect = document.getElementById('type');
    const priceInput = document.getElementById('price');
    const locationInput = document.getElementById('location');
    const addressInput = document.getElementById('address');
    const areaInput = document.getElementById('area');

    function updateWizard() {
        steps.forEach(step => step.style.display = 'none');
        document.getElementById(`wizard-step-${currentStep}`).style.display = 'block';

        const progress = ((currentStep - 1) / (totalSteps - 1)) * 100;
        indicatorLine.style.width = `${progress}%`;

        stepIndicators.forEach(indicator => {
            const stepNum = parseInt(indicator.getAttribute('data-step'));
            const circle = indicator.querySelector('.step-circle');
            const label = indicator.querySelector('span');

            if (stepNum <= currentStep) {
                circle.style.backgroundColor = 'var(--primary)';
                circle.style.color = 'white';
                if (label) label.style.color = 'var(--primary)';
            } else {
                circle.style.backgroundColor = '#e2e8f0';
                circle.style.color = 'var(--text-muted)';
                if (label) label.style.color = 'var(--text-muted)';
            }
        });

        if (currentStep === 1) {
            btnPrev.style.display = 'none';
            btnCancel.style.display = 'block';
            btnNext.style.display = 'block';
            btnSubmit.style.display = 'none';
        } else if (currentStep === totalSteps) {
            btnPrev.style.display = 'block';
            btnCancel.style.display = 'none';
            btnNext.style.display = 'none';
            btnSubmit.style.display = 'block';
        } else {
            btnPrev.style.display = 'block';
            btnCancel.style.display = 'none';
            btnNext.style.display = 'block';
            btnSubmit.style.display = 'none';
        }
    }

    function isStepValid() {
        if (currentStep === 1) {
            return titleInput.checkValidity() && 
                   typeSelect.checkValidity() && 
                   priceInput.checkValidity() && 
                   locationInput.checkValidity() && 
                   addressInput.checkValidity();
        } else if (currentStep === 2) {
            return areaInput.checkValidity();
        }
        return true;
    }

    btnNext.addEventListener('click', function() {
        if (isStepValid()) {
            if (currentStep < totalSteps) {
                currentStep++;
                updateWizard();
            }
        } else {
            const form = document.getElementById('property-form');
            form.reportValidity();
        }
    });

    btnPrev.addEventListener('click', function() {
        if (currentStep > 1) {
            currentStep--;
            updateWizard();
        }
    });


    // --- PHOTO MANAGER ---
    const imagesFilesInput = document.getElementById('images-files-input');
    const photoUrlInput = document.getElementById('photo-url-input');
    const btnAddUrl = document.getElementById('btn-add-url');
    const combinedPhotosPreview = document.getElementById('combined-photos-preview');
    const hiddenUrlsContainer = document.getElementById('hidden-urls-container');

    let pastedUrls = [];
    let localFilesList = [];

    // Load existing database URLs
    @if(old('images_urls'))
        @foreach(old('images_urls') as $oldImg)
            pastedUrls.push("{{ $oldImg }}");
        @endforeach
    @elseif(is_array($property->images))
        @foreach($property->images as $dbImg)
            pastedUrls.push("{{ $dbImg }}");
        @endforeach
    @elseif($property->image)
        pastedUrls.push("{{ $property->image }}");
    @endif

    renderCombinedPhotos();

    function renderCombinedPhotos() {
        combinedPhotosPreview.innerHTML = '';
        hiddenUrlsContainer.innerHTML = '';

        // 1. Render Local File Previews
        localFilesList.forEach((file, index) => {
            const localUrl = URL.createObjectURL(file);
            createPreviewCard(localUrl, true, index);
        });

        // 2. Render Pasted URL Previews & generate hidden fields
        pastedUrls.forEach((url, index) => {
            createPreviewCard(url, false, index);

            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'images_urls[]';
            hiddenInput.value = url;
            hiddenUrlsContainer.appendChild(hiddenInput);
        });
    }

    function createPreviewCard(src, isLocalFile, index) {
        const card = document.createElement('div');
        card.style.position = 'relative';
        card.style.width = '120px';
        card.style.height = '90px';
        card.style.borderRadius = 'var(--radius-md)';
        card.style.overflow = 'hidden';
        card.style.border = '1px solid var(--border)';
        
        const img = document.createElement('img');
        img.src = src;
        img.style.width = '100%';
        img.style.height = '100%';
        img.style.objectFit = 'cover';
        
        const btnDelete = document.createElement('button');
        btnDelete.type = 'button';
        btnDelete.innerHTML = '&times;';
        btnDelete.style.position = 'absolute';
        btnDelete.style.top = '4px';
        btnDelete.style.right = '4px';
        btnDelete.style.backgroundColor = 'rgba(239, 68, 68, 0.9)';
        btnDelete.style.color = 'white';
        btnDelete.style.border = 'none';
        btnDelete.style.borderRadius = '50%';
        btnDelete.style.width = '20px';
        btnDelete.style.height = '20px';
        btnDelete.style.display = 'flex';
        btnDelete.style.alignItems = 'center';
        btnDelete.style.justifyContent = 'center';
        btnDelete.style.cursor = 'pointer';
        btnDelete.style.fontSize = '14px';
        
        btnDelete.addEventListener('click', function() {
            if (isLocalFile) {
                localFilesList.splice(index, 1);
                const dataTransfer = new DataTransfer();
                localFilesList.forEach(file => dataTransfer.items.add(file));
                imagesFilesInput.files = dataTransfer.files;
            } else {
                pastedUrls.splice(index, 1);
            }
            renderCombinedPhotos();
        });
        
        card.appendChild(img);
        card.appendChild(btnDelete);
        combinedPhotosPreview.appendChild(card);
    }

    // Add Local Files
    imagesFilesInput.addEventListener('change', function() {
        if (imagesFilesInput.files) {
            for (let i = 0; i < imagesFilesInput.files.length; i++) {
                localFilesList.push(imagesFilesInput.files[i]);
            }
            const dataTransfer = new DataTransfer();
            localFilesList.forEach(file => dataTransfer.items.add(file));
            imagesFilesInput.files = dataTransfer.files;

            renderCombinedPhotos();
        }
    });

    // Add URL Paste
    function addPastedUrl() {
        const url = photoUrlInput.value.trim();
        if (url && (url.startsWith('http://') || url.startsWith('https://'))) {
            pastedUrls.push(url);
            photoUrlInput.value = '';
            renderCombinedPhotos();
        } else {
            alert('Format URL gambar tidak valid.');
        }
    }

    btnAddUrl.addEventListener('click', addPastedUrl);
    photoUrlInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            addPastedUrl();
        }
    });

    updateWizard();
});
</script>

@endsection
