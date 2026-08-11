import { load } from '@apple/mapkit-loader';

window.guestbookMap = function (points) {
    return {
        map: null,
        observer: null,
        visibilityObserver: null,
        allAnnotations: [],
        showSignees: true,
        showVisitors: true,
        points: points,

        async init() {
            const el = this.$refs.map;
            const meta = document.querySelector('meta[name="apple-mapkit-token"]');
            const token = meta ? meta.content : null;

            if (!token) {
                console.error('Apple MapKit token meta tag not found');
                return;
            }

            try {
                await load({ 
                    token,
                    libraries: ['map', 'annotations']
                });
                const mapkit = window.mapkit;

                this.applyThemeStyles = (isDark) => {
                    if (!this.map) return;
                    
                    const waterColor = isDark ? "#292D3E" : "#fefefe";
                    this.map.colorScheme = isDark ? mapkit.ColorScheme.Dark : mapkit.ColorScheme.Light;

                    try {
                        // Attempt MapKit JS v6 custom styling for water
                        if (mapkit.MapStyle) {
                            const style = new mapkit.MapStyle({
                                overrides: {
                                    water: {
                                        fillColor: waterColor
                                    }
                                }
                            });
                            
                            if (mapkit.StandardMapConfiguration) {
                                this.map.configuration = new mapkit.StandardMapConfiguration({ style });
                            } else if (this.map.configuration) {
                                this.map.configuration.style = style;
                            }
                        }
                    } catch (e) {
                        console.warn('MapKit custom styling failed:', e);
                    }
                };

                // Initialize map
                const isDarkInitial = document.documentElement.classList.contains('dark');
                
                this.map = new mapkit.Map(el, {
                    colorScheme: isDarkInitial ? mapkit.ColorScheme.Dark : mapkit.ColorScheme.Light,
                    showsPointsOfInterest: false,
                    showsMapTypeControl: false,
                    showsZoomControl: false,
                    showsCompass: mapkit.FeatureVisibility.Hidden,
                    showsUserLocationControl: false,
                    showsUserLocation: false,
                    padding: new mapkit.Padding(20, 20, 20, 20),
                    // Allow interaction but prevent it from bubbling to Lenis
                    allowsScrolling: true,
                    allowsZooming: true
                });

                // Desktop: Stop Lenis on hover to allow scroll-zoom without scrolling the page
                el.addEventListener('mouseenter', () => {
                    if (window.matchMedia('(min-width: 1024px)').matches) {
                        window.lenis?.stop();
                    }
                });

                el.addEventListener('mouseleave', () => {
                    if (window.matchMedia('(min-width: 1024px)').matches) {
                        window.lenis?.start();
                    }
                });

                // Mobile: Ensure touch interactions don't cause weird page scaling
                // and stop Lenis when interacting with the map
                el.addEventListener('touchstart', () => {
                    window.lenis?.stop();
                }, { passive: true });

                el.addEventListener('touchend', () => {
                    window.lenis?.start();
                }, { passive: true });

                el.addEventListener('touchcancel', () => {
                    window.lenis?.start();
                }, { passive: true });

                this.applyThemeStyles(isDarkInitial);

                // Watch for theme changes from the parent Alpine scope
                this.$watch('darkMode', (val) => {
                    this.applyThemeStyles(val);
                });

                // Watch for points changes
                this.$watch('points', (newPoints) => {
                    this.refreshAnnotations(newPoints);
                });

                // Initial annotations
                this.refreshAnnotations(this.points);

                // Default tight global view
                if (this.allAnnotations.length === 0) {
                    this.map.region = new mapkit.CoordinateRegion(
                        new mapkit.Coordinate(20, 0),
                        new mapkit.CoordinateSpan(90, 180)
                    );
                }

                // Handle resize
                this.observer = new ResizeObserver(() => {
                    // MapKit JS generally handles resize well internally
                });
                this.observer.observe(el);

            } catch (error) {
                console.error('Failed to initialize Apple MapKit:', error);
            }
        },

        refreshAnnotations(newPoints) {
            if (!this.map || !window.mapkit) return;
            const mapkit = window.mapkit;

            // Remove existing
            this.map.removeAnnotations(this.allAnnotations);

            // Create new
            this.allAnnotations = (newPoints || []).map(point => {
                const coordinate = new mapkit.Coordinate(point.lat, point.lng);
                const isSignee = point.type === 'signee';
                
                const annotation = new mapkit.MarkerAnnotation(coordinate, {
                    title: isSignee ? point.name : (point.city ? `${point.city}, ${point.state || ''}` : 'Global Visitor'),
                    subtitle: isSignee ? (point.message || 'Thanks for stopping by!') : 'Recently active on the site.',
                    color: isSignee ? "#82aaff" : "#c3e88d",
                    glyphText: "●",
                    displayPriority: isSignee ? mapkit.Annotation.DisplayPriority.High : mapkit.Annotation.DisplayPriority.Low
                });
                
                annotation.data = point;
                return annotation;
            });

            this.updateVisibleAnnotations();

            // Zoom to show all if points changed significantly
            if (this.allAnnotations.length > 0) {
                this.map.showItems(this.allAnnotations, {
                    animate: true,
                    padding: new mapkit.Padding(100, 40, 100, 40)
                });
            }
        },

        toggleLayer(type) {
            if (type === 'signee') {
                this.showSignees = !this.showSignees;
            } else if (type === 'visitor') {
                this.showVisitors = !this.showVisitors;
            }
            this.updateVisibleAnnotations();
        },

        updateVisibleAnnotations() {
            if (!this.map) return;
            
            this.map.removeAnnotations(this.map.annotations);
            
            const visible = this.allAnnotations.filter(annotation => {
                const type = annotation.data.type;
                if (type === 'signee') return this.showSignees;
                if (type === 'visitor') return this.showVisitors;
                return true;
            });
            
            this.map.addAnnotations(visible);
        },

        destroy() {
            if (this.observer) this.observer.disconnect();
            if (this.map) {
                this.map.destroy();
                this.map = null;
            }
        }
    };
}
